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
  <li><input type="button" class="button" value="Bold"></li>
  <li><input type="button" class="button" value="Italic"></li>
  <li><input type="button" class="button" value="Underline"></li>
  <li><input type="button" class="button" value="Copy"></li>
  <li><input type="button" class="button" value="Paste"></li>
</ul>
        <div id="post-body-editor" contenteditable=true>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis aliquam nisi laborum quos esse ex saepe? Enim odio deleniti id velit neque praesentium esse. Optio quia exercitationem illum ipsum doloremque!
        </div>
    </p>
    <input type="submit" value="Finish Edit" />
</form>
<script src="text-editor-draft.js"></script>
</html>