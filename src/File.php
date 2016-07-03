<?php
/**
 * This file is part of {@see \arabcoders\storage} package.
 *
 * (c) 2013-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\storage;

use \SplFileInfo;

use arabcoders\storage\
{
    Interfaces\File as FileInterface
};

/**
 * File Object
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class File implements FileInterface
{

    /**
     * @var int     File size.
     */
    private $size;

    /**
     * @var string  file mimetype.
     */
    private $mime;

    /**
     * @var string  file directory.
     */
    private $dir;

    /**
     * @var string  file name.
     */
    private $filename;

    /**
     * @var string  file extension
     */
    private $extension;

    /**
     * @var string  file thumbnail
     */
    private $thumb;

    /**
     * @var bool
     */
    private $hasThumb = false;

    /**
     * @var string  file content
     */
    private $content;

    /**
     * @var string  file checksum
     */
    private $hash;

    /**
     * @var int file date
     */
    private $date;

    public function __construct( array $file )
    {

        if ( !array_key_exists( 'mime', $file ) )
        {
            throw new \InvalidArgumentException( sprintf( '$file[\'%s\'] doesn\'t exists', 'mime' ) );
        }

        if ( !array_key_exists( 'content', $file ) )
        {
            throw new \InvalidArgumentException( sprintf( '$file[\'%s\'] doesn\'t exists', 'content' ) );
        }

        if ( !array_key_exists( 'filename', $file ) )
        {
            throw new \InvalidArgumentException( sprintf( '$file[\'%s\'] doesn\'t exists', 'filename' ) );
        }

        $this->mime = $file['mime'];

        $this->content = $file['content'];

        $this->filename = $file['filename'];

        $this->extension = ( new SplFileInfo( $file['filename'] ) )->getExtension();

        $this->date = ( array_key_exists( 'date', $file ) ) ? $file['date'] : 0;

        $this->size = ( array_key_exists( 'size', $file ) ) ? $file['size'] : 0;

        if ( !empty( $file['thumb'] ) )
        {
            $this->thumb = $file['thumb'];

            $this->hasThumb = true;
        }

        $this->hash = ( array_key_exists( 'hash', $file ) ) ? $file['hash'] : false;

        $this->dir = ( array_key_exists( 'dir', $file ) ) ? $file['dir'] : false;

        unset( $file );
    }

    public function size()
    {
        return $this->size;
    }

    public function mime()
    {
        return $this->mime;
    }

    public function dir()
    {
        return $this->dir;
    }

    public function filename()
    {
        return $this->filename;
    }

    public function extension()
    {
        return $this->extension;
    }

    public function thumb()
    {
        return $this->thumb;
    }

    public function hasThumb()
    {
        return $this->hasThumb;
    }

    public function content()
    {
        return $this->content;
    }

    public function hash()
    {
        return $this->hash;
    }

    public function date()
    {
        return $this->date;
    }
}