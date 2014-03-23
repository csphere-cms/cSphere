Webserver Configuration
-----------------------

If you want to develop locally using the PHP builtin webserver:

  The directory tools/server contains an example that runs on port 80
  If that directory does not exist you do not have the developer edition
  You may change the port if needed, everything else should already work

For all other webserver software types please read on:

  The following files include example configurations for webserver software.
  Pretty URL functionality depends on their rewrite modules and settings.
  Copy the corresponding file into the main dir of your cSphere installation.
  If your configuration files are stored somewhere else leave an empty copy there.
  Do not forget to edit that file to match your environment before using it!

  Software        | Filename
  ----------------| -------------
  Apache          | .htaccess
  Lighttpd        | lighttpd.conf
  Microsoft IIS   | web.config
  Nginx           | nginx.conf

When anything is unclear or you need help feel free to ask in our forums:

  http://www.csphere.eu
