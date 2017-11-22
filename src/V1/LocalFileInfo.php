<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   LocalFilesystem/V1
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-filesystem-plugin-local
 */

namespace GanbaroDigital\LocalFilesystem\V1;

use GanbaroDigital\Filesystem\V1\PathInfo;
use GanbaroDigital\Filesystem\V1\FileInfo;
use SplFileInfo;

/**
 * represents a file on a traditional filesystem
 */
class LocalFileInfo extends LocalPathInfo implements FileInfo
{
    /**
     * the SplFileInfo that we're wrapping
     *
     * @var SplFileInfo
     */
    protected $fileInfo;

    /**
     * our constructor
     *
     * @param string $fullPath
     *        the filesystem path that we represent
     * @param SplFileInfo|null $fileInfo
     *        a pre-existing SplFileInfo
     */
    public function __construct(string $fullPath, SplFileInfo $fileInfo = null)
    {
        parent::__construct($fullPath);

        if ($fileInfo === null) {
            $fileInfo = new SplFileInfo($this->fsPath);
        }
        $this->fileInfo = $fileInfo;
    }

    /**
     * get these details, as PHP's native SplFileInfo object
     *
     * @return SplFileInfo
     */
    public function __toSplFileInfo()
    {
        return $this->fileInfo;
    }

    // ==================================================================
    //
    // FileInfo API
    //
    // ------------------------------------------------------------------

    /**
     * what is the filename, without any parent folders?
     *
     * @return string
     */
    public function getBasename() : string
    {
        return $this->fileInfo->getBasename();
    }

    /**
     * what is the parent folder for this filename?
     *
     * returns '.' if there is no parent folder
     *
     * @return string
     */
    public function getDirname() : string
    {
        return dirname($this->fileInfo->getPathname());
    }

    /**
     * what is the file extension of this path info?
     *
     * we return an empty string if the filename has no extension
     *
     * @return string
     */
    public function getExtension() : string
    {
        return $this->fileInfo->getExtension();
    }

    /**
     * what is the real path to this file on the filesystem?
     *
     * @return string
     */
    public function getRealPath() : string
    {
        return $this->fileInfo->getRealPath();
    }

    /**
     * how big is this file?
     *
     * @return int
     */
    public function getSize() : int
    {
        return $this->fileInfo->getSize();
    }

    /**
     * can we execute this file?
     *
     * @return bool
     */
    public function isExecutable() : bool
    {
        return $this->fileInfo->isExecutable();
    }

    /**
     * is this a real file on the filesystem?
     *
     * @return bool
     *         - `false` if this is a symlink
     *         - `false` if this is a folder
     *         - `true` otherwise
     */
    public function isFile() : bool
    {
        return $this->fileInfo->isFile();
    }

    /**
     * is this a folder on the filesystem?
     *
     * @return bool
     *         - `false` if this is a file
     *         - `false` if this is a symlink
     *         - `true` otherwise
     */
    public function isFolder() : bool
    {
        return $this->fileInfo->isDir();
    }

    /**
     * is this a symlink on the filesystem?
     *
     * @return bool
     */
    public function isLink() : bool
    {
        return $this->fileInfo->isLink();
    }

    /**
     * can we read this file?
     *
     * @return bool
     */
    public function isReadable() : bool
    {
        return $this->fileInfo->isReadable();
    }

    /**
     * can we write into this file?
     *
     * @return bool
     */
    public function isWritable() : bool
    {
        return $this->fileInfo->isWritable();
    }
}