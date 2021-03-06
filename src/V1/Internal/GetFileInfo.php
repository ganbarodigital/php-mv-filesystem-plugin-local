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
 * @package   LocalFilesystem\V1\Internal
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-filesystem-plugin-local
 */

namespace GanbaroDigital\LocalFilesystem\V1\Internal;

use GanbaroDigital\Filesystem\V1\PathInfo;
use GanbaroDigital\Filesystem\V1\TypeConverters;
use GanbaroDigital\LocalFilesystem\V1\LocalFileInfo;
use GanbaroDigital\LocalFilesystem\V1\LocalFilesystem;
use GanbaroDigital\LocalFilesystem\V1\Operations;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use SplFileInfo;

/**
 * create a new LocalFileInfo object from a path
 */
class GetFileInfo
{
    /**
     * create a new LocalFileInfo object from a path
     *
     * @param  string|PathInfo $fullPath
     *         the path we want more information about
     * @param  OnFatal $onFatal
     *         what do we do if there's a problem?
     * @return LocalFileInfo
     */
    public static function for(LocalFilesystem $fs, $fullPath, OnFatal $onFatal) : LocalFileInfo
    {
        $pathInfo = TypeConverters\ToPathInfo::from($fullPath);

        // does it exist?
        try {
            $rawFileInfo = new SplFileInfo($pathInfo->getFullPath());
        }
        catch (\Exception $e) {
            // it does not, and we do not know why
            throw $onFatal($pathInfo->getPrefixedPath(), $e->getMessage());
        }

        // success!
        $metadata = Operations\GetFileMetadata::using($fs, $fullPath, $onFatal);
        return new LocalFileInfo($pathInfo, $rawFileInfo, $metadata);
    }
}