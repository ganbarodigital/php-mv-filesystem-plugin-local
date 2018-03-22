# CHANGELOG

## develop branch

### New

* Added values to represent things on the filesystem
  - added `LocalPathInfo`
  - added `LocalFileInfo`
  - added `LocalFilesystem`
  - added `LocalFilesystemContents`
* Added support for converting to the local FileInfo type
  - added `TypeConverters\ToFileInfo`
* Added internal helpers
  - added `GetFileInfo`
  - added `GetFolderListing`
* Added support for iterating over the local filesystem
  - added `GetContentsIterator`
* Added support for creating the local filesystem via a factory
  - added `LocalFilesystemFactory`
* Added basic filesystem operations
  - added `GetFileContents` operation
  - added `PutFileContents` operation
  - added `Unlink` operation
* Added support for key/value pair metadata
  - added `GetFileMetadata` operation
  - added `PutFileMetadata` operation