document.querySelectorAll('.block').forEach(block => {
  block.addEventListener('dragstart', e => {
    e.dataTransfer.setData('text/plain', block.dataset.id);
  });
});

document.getElementById('editor-area').addEventListener('dragover', e => {
  e.preventDefault();
  const afterElement = getDragAfterElement(e.clientY);
  const dragging = document.querySelector('.dragging');
  if (afterElement == null) {
    e.currentTarget.appendChild(dragging);
  } else {
    e.currentTarget.insertBefore(dragging, afterElement);
  }
});

function getDragAfterElement(y) {
  const blocks = [...document.querySelectorAll('.block:not(.dragging)')];
  return blocks.reduce((closest, child) => {
    const box = child.getBoundingClientRect();
    const offset = y - box.top - box.height / 2;
    if (offset < 0 && offset > closest.offset) {
      return { offset: offset, element: child };
    } else {
      return closest;
    }
  }, { offset: Number.NEGATIVE_INFINITY }).element;
}

document.querySelectorAll('.image-upload').forEach(input => {
  input.addEventListener('change', e => {
    const reader = new FileReader();
    reader.onload = function (event) {
      input.nextElementSibling.src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
  });
});

document.getElementById('block-form').addEventListener('submit', async e => {
  e.preventDefault();
  const blocks = [...document.querySelectorAll('.block')];
  const formData = new FormData();

  blocks.forEach((block, index) => {
    formData.append(`blocks[${index}][id]`, block.dataset.id || '');
    formData.append(`blocks[${index}][content]`, block.querySelector('textarea').value);
    const file = block.querySelector('.image-upload').files[0];
    if (file) formData.append(`blocks[${index}][image]`, file);
  });

  const res = await fetch('../api/save_blocks.php', {
    method: 'POST',
    body: formData
  });

  if (res.ok) alert('Saved!');
  else alert('Save failed');
});
