<html>
<link rel="stylesheet" type="text/css" href="text-editor-draft.css">
Selection:
<br>
<textarea id="sel" rows="3" cols="50"></textarea>
<p>Please select some text.</p>
<input value="Some text in a text input">
<br>
<input type="search" value="Some text in a search input">
<br>
<input type="tel" value="4872349749823">
<br>
<textarea>Some text in a textarea</textarea>
<script src="text-editor-draft.js"></script>

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
        <textarea
            id="post-body"
            name="post-body"
            rows="8"
            cols="70"
        >Lorem ipsum Body</textarea>
    </p>
    <input type="submit" value="Finish Edit" />
</form>
</html>