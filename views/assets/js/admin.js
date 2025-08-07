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

  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
  }
  
  const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

// Mobile overlay + sidebar open
document.getElementById("overlay")?.addEventListener("click", () => {
  sidebar.classList.remove("mobile-open");
  document.getElementById("overlay").classList.add("hidden");
});

// Optional: show overlay and slide sidebar for mobile toggle
toggleBtn?.addEventListener("click", () => {
  if (window.innerWidth <= 768) {
    sidebar.classList.add("mobile-open");
    document.getElementById("overlay").classList.remove("hidden");
  } else {
    sidebar.classList.toggle("collapsed");
  }
});


function toggleDropdown(id) {
  const dropdown = document.getElementById(id);
  const icon = dropdown.previousElementSibling.querySelector('.fa-caret-down');

  const isOpen = dropdown.style.display === "block";

  dropdown.style.display = isOpen ? "none" : "block";

  if (icon) {
    icon.classList.toggle("rotate", !isOpen);
  }
}