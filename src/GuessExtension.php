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

/**
 * Guess File Extension
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class GuessExtension
{
    /**
     * @var array
     */
    private $mimetypes = [ ];

    /**
     * @var string
     */
    private $mimetype;

    /**
     * @param string|null $mimetype
     *
     * @throws \RuntimeException
     */
    public function __construct( $mimetype = null )
    {
        if ( is_null( $mimetype ) )
        {
            $mimetype = __DIR__ . DIRECTORY_SEPARATOR . 'mimetypes.json';
        }

        if ( !( $this->mimetypes = json_decode( file_get_contents( $mimetype ), true ) ) )
        {
            throw new \RuntimeException( sprintf( 'Unable to decode mimetype data: %s ', $mimetype, json_last_error() ) );
        }
    }

    /**
     * @param $mimetype
     *
     * @return $this
     */
    public function setMimetype( $mimetype )
    {
        $this->mimetype = strtolower( $mimetype );

        return $this;
    }

    /**
     * search for the mimetype and return the extension.
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function guess()
    {
        if ( !isset( $this->mimetypes[$this->mimetype] ) )
        {
            throw new \RuntimeException( sprintf( 'Mimetype (%s) is not found in the database', $this->mimetype ) );
        }

        return $this->mimetypes[$this->mimetype];
    }

    public function parseLive()
    {
        $text = file_get_contents( 'https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types' );
        $text = explode( PHP_EOL, $text );
        $arr  = [ ];

        foreach ( $text as $key => $value )
        {
            if ( substr( $value, 0, 1 ) == '#' )
            {
                continue;
            }
            if ( preg_match( '#(.+?)[ \t\n\r]+(\w{2,6})#is', $value, $match ) )
            {
                $arr[$match[1]] = $match[2];
            }
        }

        return json_encode( $arr );
    }

}