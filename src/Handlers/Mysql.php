<?php
/**
 * This file is part of {@see \arabcoders\storage} package.
 *
 * (c) 2013-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\storage\Handlers;

use arabcoders\storage\
{
    File as File,
    Interfaces\File as FileInterface,
    Interfaces\Handler as HandlerInterface
};

/**
 * Handler: Mysql.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Mysql implements HandlerInterface
{
    /**
     * @var string
     */
    public $error;

    /**
     * @var \Pdo
     */
    private $pdo;

    /**
     * @var FileInterface
     */
    private $file;

    /**
     * @var array schema
     */
    private $schema = [
        'id'      => 'id',
        'date'    => 'date',
        'size'    => 'size',
        'type'    => 'type',
        'hash'    => 'hash',
        'name'    => 'name',
        'content' => 'content',
        'isthumb' => 'isthumb',
        'thumb'   => 'thumb',
    ];

    /**
     * @var array schema
     */
    private $table = 'storage';

    /**
     * {@inheritdoc}
     */
    public function __construct( \PDO $pdo, array $options = [ ] )
    {
        $this->pdo = $pdo;

        if ( array_key_exists( 'schema', $options ) && is_array( $options['schema'] ) )
        {
            $this->schema = array_merge( $this->schema, $options['schema'] );
        }

        if ( array_key_exists( 'table', $options ) && is_array( $options['table'] ) )
        {
            $this->table = $options['table'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFile( FileInterface $fileObject )
    {
        $this->file = $fileObject;
    }

    /**
     * {@inheritdoc}
     */
    public function delete( $id, array $options = [ ] )
    {
        $sql = "DELETE FROM {$this->table} WHERE " . $this->schema['id'] . " = :id";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute( [ 'id' => $id ] );

        return ( $stmt->rowCount() ) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function read( $id, array $options = [ ] )
    {

        $sql       = "SELECT * FROM {$this->table} WHERE " . $this->schema['id'] . " = :id";
        $arrParams = [ 'id' => $id ];
        $stmt      = $this->pdo->prepare( $sql );

        $stmt->execute( $arrParams );

        if ( !$stmt->rowCount() )
        {
            return false;
        }

        $stmt = $stmt->fetch();

        $file = new File( [
                              'size'     => $stmt[$this->schema['size']],
                              'mime'     => $stmt[$this->schema['type']],
                              'hash'     => $stmt[$this->schema['hash']],
                              'date'     => $stmt[$this->schema['date']],
                              'filename' => $stmt[$this->schema['name']],
                              'content'  => $stmt[$this->schema['content']],
                              'thumb'    => ( $stmt[$this->schema['isthumb']] ) ? $stmt[$this->schema['thumb']] : false,
                          ] );
        $stmt = null;

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function exists( $id, array $options = [ ] )
    {
        $sql  = "SELECT " . $this->schema['id'] . " FROM {$this->table} WHERE " . $this->schema['id'] . " = :id";
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute( [ 'id' => $id ] );

        return ( $stmt->rowCount() ) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function update( $id, array $options = [ ] )
    {

        $arrParams = [
            'id'      => $id,
            'date'    => time(),
            'size'    => $this->file->size(),
            'type'    => $this->file->mime(),
            'hash'    => $this->file->hash(),
            'name'    => $this->file->filename(),
            'content' => $this->file->content(),
        ];

        $sql_thumb = '';

        if ( !( $thumb = &$this->file->thumb() ) )
        {
            $arrParams = array_merge( $arrParams, [ 'thumb' => &$thumb ] );
            $sql_thumb = "
                " . $this->schema['isthumb'] . "    = 1,
                " . $this->schema['thumb'] . "      = :thumb,
            ";
        }

        $sql = "UPDATE
                    {$this->table}
                SET
                    {$sql_thumb}
                    " . $this->schema['date'] . "       = :date,
                    " . $this->schema['size'] . "       = :size,
                    " . $this->schema['type'] . "       = :type,
                    " . $this->schema['hash'] . "       = :hash,
                    " . $this->schema['name'] . "       = :name,
                    " . $this->schema['content'] . "    = :content
                WHERE
                    " . $this->schema['id'] . "         = :id
        ";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute( $arrParams );

        return ( $stmt->rowCount() ) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function store( array $options = [ ] )
    {
        $id = ( array_key_exists( 'id', $options ) ) ? $options['id'] : $this->createId();

        $arrParams = [
            'id'      => $id,
            'date'    => time(),
            'size'    => $this->file->size(),
            'type'    => $this->file->mime(),
            'hash'    => $this->file->hash(),
            'name'    => $this->file->filename(),
            'content' => $this->file->content(),
        ];

        $sql_thumb = '';

        if ( ( $thumb = $this->file->thumb() ) )
        {
            $arrParams = array_merge( $arrParams, [ 'thumb' => $thumb ] );
            $sql_thumb = "
                " . $this->schema['isthumb'] . "    = 1,
                " . $this->schema['thumb'] . "      = :thumb,
            ";
        }

        $sql = "INSERT INTO
                    {$this->table}
                SET
                    {$sql_thumb}
                    `" . $this->schema['id'] . "`         = :id,
                    `" . $this->schema['date'] . "`       = :date,
                    `" . $this->schema['size'] . "`       = :size,
                    `" . $this->schema['type'] . "`       = :type,
                    `" . $this->schema['hash'] . "`       = :hash,
                    `" . $this->schema['name'] . "`       = :name,
                    `" . $this->schema['content'] . "`    = :content
        ";

        $stmt = $this->pdo->prepare( $sql );

        try
        {
            $stmt->execute( $arrParams );
        }
        catch ( \PDOException $e )
        {
            $this->error = $e->getMessage();

            return false;
        }

        unset( $arrParams );

        return $id;
    }

    private function createId()
    {
        $id = bin2hex( random_bytes( 7 ) );

        if ( is_float( $id ) )
        {
            return $this->createId();
        }

        return $id;
    }
}