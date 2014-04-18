# MDEditor

![MDEditor Screenshot](http://i.imgur.com/AXKyN6X.png)

## This is a public Alpha version of MDEditor

### Install Editor:

HTML markup:
```html
<textarea id="mdeditor" name="mdeditor"></textarea>
```
Without options:
```javascript
$.("#mdeditor").mdeditor();
```
With options:
```javascript
$.("#mdeditor").mdeditor({
	language: 'en-US', // language of editor
	width: '100%', // width of editor
	height: '250px', // height of textarea in the editor
	specialBar: true, // includes the second (special) toolbar
	formControl: true, // includes form submit, reset and a go back button
	codeIcon: true, // includes button for code markup
	mailIcon: true, // includes button for a mail hyperlink markup
	phoneIcon: true, // includes button for a phone hyperlink markup
	iconsIcon: true, // includes button for fontawesome icons
	helpIcon: true, // includes help button
	preview: true, // includes preview button
	attachment: true, // includes attachment button
	wordCounter: true, // includes word counter
	includeTipsy: true, // includes tipsy, if you haven't already done this
	wordWrap: true, // wordwrap in textarea
	theme: false, // choose a theme -> false = no theme
	maxUpload: 2000000 // 2MB
});
```

> For attachment you need [php](https://github.com/php/php-src) and the [json extension for php](http://www.php.net/manual/de/book.json.php)!