// Function to handle form submission via AJAX
function submitForm(formId, url, callback) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            callback(xhr.responseText);  // Execute callback with response text
        } else {
            alert("There was an error submitting the form. Please try again.");
        }
    };
    xhr.send(formData);
}

// Show or hide the add/edit content form
function toggleForm(formId) {
    const form = document.getElementById(formId);
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

// Form validation before submission
function validateForm(formId) {
    const form = document.getElementById(formId);
    const title = form.querySelector("input[name='title']").value;
    const description = form.querySelector("textarea[name='description']").value;
    const details = form.querySelector("textarea[name='details']").value;

    if (!title || !description || !details) {
        alert("Please fill in all fields.");
        return false;  // Prevent form submission if validation fails
    }

    return true;  // Allow form submission
}

// Handle Add Content form submission
document.getElementById("addContentForm").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent default form submission

    if (validateForm("addContentForm")) {
        submitForm("addContentForm", "add_content.php", function(response) {
            alert("Content added successfully!");
            window.location.reload();  // Reload the page to show the new content
        });
    }
});

// Handle Edit Content form submission
document.getElementById("editContentForm").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent default form submission

    if (validateForm("editContentForm")) {
        submitForm("editContentForm", "edit_content.php", function(response) {
            alert("Content updated successfully!");
            window.location.reload();  // Reload the page to show the updated content
        });
    }
});

// Delete content with a confirmation prompt
function deleteContent(contentId) {
    const confirmDelete = confirm("Are you sure you want to delete this content?");
    if (confirmDelete) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_content.php?id=" + contentId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Content deleted successfully!");
                window.location.reload();  // Reload the page to remove deleted content
            } else {
                alert("There was an error deleting the content. Please try again.");
            }
        };
        xhr.send();
    }
}

// Function to show the success or error message
function showMessage(message, type) {
    const messageBox = document.createElement("div");
    messageBox.textContent = message;
    messageBox.classList.add(type === "success" ? "success" : "error");
    document.body.appendChild(messageBox);
    setTimeout(() => messageBox.remove(), 5000);
}

// Example function to load content dynamically using AJAX (optional feature)
function loadContent(topicId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_content.php?topic_id=" + topicId, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("contentList").innerHTML = xhr.responseText;
        } else {
            alert("Error loading content.");
        }
    };
    xhr.send();
}

// Initial load for content based on topic (optional)
document.addEventListener("DOMContentLoaded", function() {
    loadContent(2);  // Example: load content for topic_id = 2 (Salah)
});
