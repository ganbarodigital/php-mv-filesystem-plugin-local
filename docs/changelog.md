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