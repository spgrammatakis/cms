<html>
<head>
<link rel="stylesheet" type="text/css" href="/template/text-editor/text-editor.css">
</head>
<body>
<form method="post" id="post-edit" onsubmit="copyConent()" >
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
<iframe id="post-editor-iframe" width="50%" height="600" onload="iframeInit()" style="border-style:none" src="../templates/text-editor/text-editor.html">
</iframe>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>
</body>
</html>