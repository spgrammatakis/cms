<html>
<head>
</head>
<body>
<form method="post" id="post-edit" onsubmit="copyToHidden()">
<h3>Edit your post</h3>
<p>
        <textarea
            id="post-title-textarea"
            name="post-title-textarea"
            form="post-edit"
            style="display:none;"
        ></textarea>
    </p>
    <p>
        <textarea
            id="post-body-textarea"
            name="post-body-textarea"
            form="post-edit"
            style="display:none;"
        ></textarea>
    </p>
</br>
<iframe id="post-editor-iframe" width="50%" height="600" onload="ifameInit()" style="border-style:none" src="templates/text-editor/text-editor.html">
</iframe>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>
</body>
</html>