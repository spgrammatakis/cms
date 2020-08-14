<html>
<link rel="stylesheet" type="text/css" href="text-editor-draft.css">
<div class="wrapper">
  <h1>New Post</h1>
  <input type="text" placeholder="Title">
  <div class="options">
    <button onClick="transform('bold', null)">
      <i class="fas fa-bold"></i>
    </button>
    <button onClick="transform('italic', null)">
      <i class="fas fa-italic"></i>
    </button>
    <button onClick="transform('strikeThrough', null)">
      <i class="fas fa-strikethrough"></i>
    </button>
    <button onClick="transform('underline', null)">
      <i class="fas fa-underline"></i>
    </button>
    <div class="seperator"></div>
    <button onClick="transform('justifyLeft', null)">
      <i class="fas fa-align-left"></i>
    </button>
    <button onClick="transform('justifyCenter', null)">
      <i class="fas fa-align-center"></i>
    </button>
    <button onClick="transform('justifyRight', null)">
      <i class="fas fa-align-right"></i>
    </button>
    <div class="seperator"></div>
    <button onClick="transform('insertOrderedList', null)">
      <i class="fas fa-list-ol"></i>
    </button>
    <button onClick="transform('insertUnorderedList', null)">
      <i class="fas fa-list-ul"></i>
    </button>
    <div class="seperator"></div>
    <select onChange="transform('fontName', this.value)">
      <option disabled default>Font</option>
      <option value="Times New Roman">Times</option>
      <option value="Arial">Arial</option>
      <option value="Courier New">Courier New</option>
      <option value="Tahoma">Tahoma</option>
      <option value="Arial">Verdana</option>
    </select>
    <div class="seperator"></div>
    <input type="number" onChange="transform('fontSize', this.value)" value="3" max="7" min="1"></input>
  </div>
  <iframe name="editor" id="editor"></iframe>
</div>
<script src="text-editor-draft.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>  
</html>