
<hr style='border: 5px solid red;'>
<h3>Edit your post</h3>
<form method="post" id="post-edit" onsubmit="copyContent()" >
<p>
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="<?php echo $pdo->htmlEscape($row['title'])?>"
        >
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
  <li><button type="button" class="button" value="Bold" onclick="formatText(this)">Bold</button></li>
  <li><button type="button" class="button" value="Italic" onclick="formatText(this)">Italic</button></li>
  <li><button type="button" class="button" value="Underline" onclick="formatText(this)">Underline</button></li>
  <li><button type="button" class="button" value="Insert Link" onclick="formatText(this)">Insert Link</button></li>
  <li><button type="button" class="button" value="Copy" onclick="copyContent()">Copy</button></li>
  <li><button type="button" class="button" value="Paste" onclick="appendnode()">Test</button></li>
</ul>
        <div id="post-body-editor" contenteditable=true>
        <?php echo $pdo->htmlEscape($row['body']);?>
        </div>
    </p>
    <input type="submit" value="Finish Edit"/>
</form>