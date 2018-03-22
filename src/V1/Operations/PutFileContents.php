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
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-filesystem-plugin-local
 */

namespace GanbaroDigital\LocalFilesystem\V1\Operations;

use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginClass;
use GanbaroDigital\Filesystem\V1\Checks;
use GanbaroDigital\Filesystem\V1\TypeConverters;
use GanbaroDigital\LocalFilesystem\V1\Internal;
use GanbaroDigital\LocalFilesystem\V1\LocalFilesystem;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;

/**
 * save data to a file
 */
class PutFileContents implements PluginClass
{
    /**
     * save data to a file
     *
     * @param  LocalFilesystem $fs
     *         the filesystem we are working with
     * @param  string|PathInfo $path
     *         what are we writing to?
     * @param  string $contents
     *         what are we saving into $path?
     * @param  OnFatal $onFatal
     *         what do we do when the write fails?
     * @return void
     */
    public static function using(LocalFilesystem $fs, $path, string $contents, OnFatal $onFatal)
    {
        // what are we looking at?
        $pathInfo = TypeConverters\ToPathInfo::from($path);

        if (Checks\IsFolder::check($fs, $pathInfo)) {
            throw $onFatal("already exists, is a folder");
        }

        // quick check - do we already have this content?
        //
        // we may be writing to a very slow / oversubscribed device,
        // such as NFS.
        // we may be writing to a replicating folder, managed by Dropbox
        // or equivalent.
        //
        // we want to avoid writes where we can
        if (Internal\IsDuplicateContent::check($pathInfo->getFullPath(), $contents)) {
            return;
        }

        // TODO: add robustness
        file_put_contents($pathInfo->getFullPath(), $contents);
    }
}