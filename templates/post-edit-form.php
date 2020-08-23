<html>
<link rel="stylesheet" type="text/css" href="../templates/text-editor/text-editor.css">
<body>
<form method="post" id="post-edit" onsubmit="copyContent()" >
<h3>Edit your post</h3>
<p>
        <label for="post-title">Title:</label>
        <input
            id="post-title"
            name="post-title"
            form="post-edit"
        >
        <div id="post-title-editor" contenteditable=true>
        </div>
    </p>
    <p>
    <label for="post-body">
        Post-Body
    </label>
        <textarea
            id="post-body"
            name="post-body"
            form="post-edit"
            style="display:none"
        ></textarea>
</br>
<ul>
  <li><button type="button" class="button" value="Bold" onclick="formatBold()">Bold</button></li>
  <li><button type="button" class="button" value="Italic" onclick="formatItalic()">Italic</button></li>
  <li><button type="button" class="button" value="Underline" onclick="formatUnderline()">Underline</button></li>
  <li><button type="button" class="button" value="Insert Link" onclick="formatInsertLink()">Insert Link</button></li>
  <li><button type="button" class="button" value="Copy" onclick="copyContent()">Copy</button></li>
  <li><button type="button" class="button" value="Paste" onclick="appendnode()">Test</button></li>
</ul>
        <div id="post-body-editor" contenteditable=true>
        </div>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>
</body>
</html>