<?php
namespace froggdev\PhpUtils;

Abstract class FileUtil
{
  /**
   * Delete a folder and its content, can remove only a folder content if $delMainDir is set to false
   *
   * @param string $dir
   * @return bool
   */
  public static function delTree(string $dir,bool $delMainDir=true): bool
  {
    // get folder content ignoring . and ..
    $files = @array_diff(@scandir($dir), array('.', '..'));

    // if found results
    if($files){
      foreach ($files as $file) {
        $path = "$dir/$file";
        // if it is a file delete it, else call recursively deletree
        (is_dir($path)) ? self::delTree($path) : @unlink($path);
      }
    }

    // delete only main dir content if asked to (keep the main dir)
    if( false===$delMainDir ) return true;

    // remove folder
    return @rmdir($dir);
  }

  /**
   * Write content into a file, and create folder tree if requiered
   *
   * @param $filePath
   * @param $content
   */
  public static function writeTofile( $filePath , $content ): void
  {
    $dir = @dirname($filePath);

    //create directory if it doesn't exist
    if (!@file_exists($dir)) {
      @mkdir($dir, 0777, true);
    }

    // send data to the file
    @file_put_contents(
      $filePath,
      $content
    );
  }


  /**
   * Save a file content as UTF-8
   * 
   * @param string $file
   * @param string $content
   */
  public static function saveFileAsUTF8(string $file, string $content)
  {
    // Create the dir if not exist
    $dir = dirname($file);
    if (!file_exists($dir)) mkdir($dir, 0777, true);

    // save as UTF 8 format
    $f = fopen($file, "w");
    # Now UTF-8 - Add byte order mark
    fwrite($f, pack("CCC", 0xef, 0xbb, 0xbf));
    fwrite($f, $content);
    fclose($f);
  }

  /**
   * check if a remote file exists
   *
   * @param string $url
   * @return bool
   */
  public static function fileUrlExist(string $url): bool
  {
    $file_headers = @get_headers($url);

    return (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found');

    /* CURL VERSION :
     * if (!$fp = curl_init($url)) return false;
     * return true;
     */
  }
    
  /**
   * find and replace in a file using reg exp
   *
   * @param string $filePath
   * @param string $regExp
   * @param string $replacement
   */
  public static function regReplaceInFile(string $filePath, string $regExp, string $replacement): void
  {
    $fileContents = file_get_contents($filePath);
    $fileContents = preg_replace ($regExp,$replacement,$fileContents);
    file_put_contents($filePath,$fileContents);
  }

  /**
   * Replace cofiguration in YAML file
   *
   * @param string $filePath
   * @param array $configs
   */
  public static function regReplaceYamlConfigFile(string $filePath,array $configs): void
  {
    $fileContents = file_get_contents($filePath);

    foreach($configs as $key => $value){
      $fileContents = preg_replace ("/- ${key}: [^\s]+/i","- ${key}: ${value}",$fileContents);
    }

    file_put_contents($filePath,$fileContents);
  }
    
  /**
   * Copy a file, or recursively copy a folder and its contents
   *
   * @author      Aidan Lister <aidan@php.net>
   * @version     1.0.1
   * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
   * @param       string $source Source path
   * @param       string $dest Destination path
   * @param       bool $silent
   * @return      bool     Returns TRUE on success, FALSE on failure
   */
  public static function copyr(string $source,string $dest , bool $silent = true)
  {
    // Check if source exist
    if (!file_exists($source) && $silent) return false;

    // Check for symlinks
    if (is_link($source)) return symlink(readlink($source), $dest);

    // Simple copy for a file
    if (is_file($source)) return copy($source, $dest);

    // Make destination directory
    if (!is_dir($dest)) mkdir($dest,0777 ,true);

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') continue;

        // Deep copy directories
        self::copyr("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    
    return true;
  }
}
