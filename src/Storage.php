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

use arabcoders\storage\
{
    Interfaces\File as FileInterface,
    Interfaces\Storage as StorageInterface,
    Interfaces\Handler as HandlerInterface
};

/**
 * Storage Manager
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Storage implements StorageInterface
{
    /**
     * @var HandlerInterface
     */
    private $handler;

    public function __construct( HandlerInterface $handler, array $options = [ ] )
    {
        $this->handler = &$handler;
    }

    public function setFile( FileInterface $fileObject )
    {
        $this->handler->setFile( $fileObject );

        return $this;
    }

    public function delete( $id, array $options = [ ] )
    {
        return $this->handler->delete( $id, $options );
    }

    public function read( $id, array $options = [ ] )
    {
        return $this->handler->read( $id, $options );
    }

    public function exists( $id, array $options = [ ] )
    {
        return $this->handler->exists( $id, $options );
    }

    public function update( $id, array $options = [ ] )
    {
        return $this->handler->update( $id, $options );
    }

    public function store( array $options = [ ] )
    {
        return $this->handler->store( $options );
    }

    public function setHandler( HandlerInterface $handler ): StorageInterface
    {
        $this->handler = &$handler;

        return $this;
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    public function __get( $name )
    {
        if ( property_exists( $this->handler, $name ) )
        {
            return $this->handler->{$name};
        }

        return null;
    }
}