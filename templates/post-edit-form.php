<html>
<body>
<form method="post" id="post-edit" onsubmit="postContent()" >
<h3>Edit your post</h3>
<p>
        <input
            id="post-title"
            name="post-title"
            form="post-edit"
            style="display:none"
        >
    </p>
    <p>
        <textarea
            id="post-body"
            name="post-body"
            form="post-edit"
            style="display:none"
            class="post-body-textarea"
        ></textarea>
</br>
<iframe id="post-editor-iframe" width="50%" height="500" frameBorder="0" src="../templates/text-editor/text-editor.html">
</iframe>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>
</body>
</html>