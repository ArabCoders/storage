<?php
/**
 * This file is part of {@see \arabcoders\storage} package.
 *
 * (c) 2013-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\storage\Interfaces;

/**
 * Storage Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
interface Storage extends Handler
{
    /**
     * Class Constructor
     *
     * @param Handler $handler
     * @param array   $options
     */
    public function __construct( Handler $handler, array $options = [ ] );

    /**
     * set Handler
     *
     * @param Handler  Handler Interface
     *
     * @return Storage
     */
    public function setHandler( Handler $handler ): Storage;

    /**
     * get Handler
     *
     * @param HandlerInterface  Handler Interface
     *
     * @return Handler
     */
    public function getHandler(): Handler;
}