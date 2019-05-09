RSSMii Displayer
================
This is the server component of [RSSMii](https://github.com/WiiDatabase/RSSMii). The PHP file takes two arguments:
* `feedurl`: URL to an RSS feed
* `title`: Title of the message at the Wii message board

On the first run (of RSSMii), it returns the last item. On subsequent runs, it checks the `If-Modified-Since` header and returns only newer entries.

## Installation
1. You need PHP and [Composer](https://getcomposer.org/)
2. Run `composer install` in this repository
3. Finished!

## Credits
* Original code by [RiiConnect24](https://github.com/RiiConnect24/rssmii)
* Original idea by [main()](https://github.com/Gamer125/rssmii)

### Read more
* [WiiBrew](https://wiibrew.org/wiki/WiiConnect24#Mail_headers)
* [SimplePie](https://simplepie.org/)
* [html2text](https://github.com/soundasleep/html2text)
