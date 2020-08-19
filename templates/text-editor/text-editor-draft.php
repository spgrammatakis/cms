<html>
<link rel="stylesheet" type="text/css" href="text-editor-draft.css">
<hr style='border: 5px solid red;'>
<h3>Edit your post</h3>
<form method="post">
<p>
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="Lorem Title"
        >
    </p>
    <p>
        <label for="post-body">
            Website:
        </label>

        <input
            name="post-body"
            style="display:none"
        >
</br>
<ul>
  <li><button type="button" class="button" value="Bold" onclick="formatText(this)">Bold</button></li>
  <li><button type="button" class="button" value="Italic" onclick="formatText(this)">Italic</button></li>
  <li><button type="button" class="button" value="Underline" onclick="formatText(this)">Underline</button></li>
  <li><button type="button" class="button" value="Copy" onclick="formatText(this)">Copy</button></li>
  <li><button type="button" class="button" value="Paste" onclick="formatText(this)">Paste</button></li>
</ul>
        <div id="post-body-editor" contenteditable=true>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis aliquam nisi laborum quos esse ex saepe? Enim odio deleniti id velit neque praesentium esse. Optio quia exercitationem illum ipsum doloremque!
        </div>
    </p>
    <textarea name="hiddenTextArea" id="hiddenTextArea" style="display:none;"></textarea>
    <input type="submit" value="Finish Edit" onsubmit="return copyContent()" />
</form>
<script src="text-editor-draft.js"></script>
</html>