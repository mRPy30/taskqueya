function addBlock() {
    const div = document.createElement('div');
    div.className = 'block';
    div.innerHTML = '<textarea name="blocks[]"></textarea><button type="button" onclick="removeBlock(this)">Remove</button>';
    document.getElementById('blocks-container').appendChild(div);
  }
  
  function removeBlock(btn) {
    btn.parentElement.remove();
  }

  document.addEventListener("DOMContentLoaded", function () {
    const addBtn = document.getElementById("show-new-section");
    const newSectionForm = document.getElementById("new-section-form");

    newSectionForm.style.display = "none";

    addBtn.addEventListener("click", function () {
      newSectionForm.style.display = newSectionForm.style.display === "none" ? "block" : "none";
    });
  });