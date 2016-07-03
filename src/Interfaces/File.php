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
 * File Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
interface File
{
    /**
     * Get File Size
     *
     * @return int
     */
    public function size();

    /**
     * Get File Mimetype.
     *
     * @return string
     */
    public function mime();

    /**
     * Get file directory
     *
     * @return string
     */
    public function dir();

    /**
     * Get File name.
     *
     * @return string
     */
    public function filename();

    /**
     * Get file extension
     *
     * @return string
     */
    public function extension();

    /**
     * Get file thumbnail
     *
     * @return string
     */
    public function thumb();

    /**
     * Get File Content
     *
     * @return string
     */
    public function content();

    /**
     * Get File hash
     *
     * @return string
     */
    public function hash();

    /**
     * Get File Date
     *
     * @return int
     */
    public function date();
}