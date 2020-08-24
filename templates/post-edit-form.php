<html>
<head>
</head>
<body>
<form method="post" id="post-edit" onsubmit="copyToHidden()" >
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
    </p>
</br>
<iframe id="post-editor-iframe" width="50%" height="600" onload="iframeInit()" style="border-style:none" src="../templates/text-editor/text-editor.html">
</iframe>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>
</body>
<script type="text/javascript" src="../templates/text-editor/text-editor.js"></script>
</html>