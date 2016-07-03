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

use arabcoders\storage\Interfaces\File as FileInterface;

/**
 * Handler Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
interface Handler
{
    /**
     * Class Constructor
     *
     * @param File $fileObject
     *
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public function setFile( File $fileObject );

    /**
     * Delete Content
     *
     * @param mixed $id
     * @param array $options
     *
     * @throws \InvalidArgumentException   When error encountered.
     *
     * @return bool
     */
    public function delete( $id, array $options = [ ] );

    /**
     * Return File Object
     *
     * @param mixed $id
     * @param array $options
     *
     * @throws \InvalidArgumentException When error encountered.
     *
     * @return FileInterface
     */
    public function read( $id, array $options = [ ] );

    /**
     * Check if File Exists.
     *
     * @param mixed $id
     * @param array $options
     *
     * @return bool
     */
    public function exists( $id, array $options = [ ] );

    /**
     * Update Record File Object
     *
     * @param mixed $id
     * @param array $options
     *
     * @throws \InvalidArgumentException When error encountered.
     *
     * @return bool
     */
    public function update( $id, array $options = [ ] );

    /**
     * Store File Object
     *
     * @param array $options
     *
     * @throws \InvalidArgumentException When error encountered.
     * @throws \InvalidArgumentException When fileObject is not set
     *
     * @return string identifer for this specifc file.
     */
    public function store( array $options = [ ] );
}