document.addEventListener('DOMContentLoaded', function() {
    // Hamburger menu functionality
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }

    // Close menu when a link is clicked
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            if (hamburger) hamburger.classList.remove('active');
            if (navLinks) navLinks.classList.remove('active');
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showToast('Please fill in all required fields.', 'error');
            }
        });
    });

    // Edit profile popup functionality
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfilePopup = document.getElementById('edit-profile-popup');
    const closePopupBtn = document.querySelector('.close');

    if (editProfileBtn && editProfilePopup) {
        editProfileBtn.addEventListener('click', function() {
            editProfilePopup.style.display = 'block';
        });
    }

    if (closePopupBtn) {
        closePopupBtn.addEventListener('click', function() {
            editProfilePopup.style.display = 'none';
        });
    }

    // Close popup when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === editProfilePopup) {
            editProfilePopup.style.display = 'none';
        }
    });

    // Organization profile popup (if needed)
    const editOrgProfileBtn = document.getElementById('edit-org-profile-btn');
    const editOrgProfilePopup = document.getElementById('edit-org-profile-popup');
    
    if (editOrgProfileBtn && editOrgProfilePopup) {
        editOrgProfileBtn.addEventListener('click', function() {
            editOrgProfilePopup.style.display = 'block';
        });

        // Close org profile popup
        const closeOrgPopupBtn = editOrgProfilePopup.querySelector('.close');
        if (closeOrgPopupBtn) {
            closeOrgPopupBtn.addEventListener('click', function() {
                editOrgProfilePopup.style.display = 'none';
            });
        }

        // Close org popup when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === editOrgProfilePopup) {
                editOrgProfilePopup.style.display = 'none';
            }
        });
    }

    // Profile picture preview
    var profilePictureInput = document.getElementById('profile_picture');
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'profile-picture standardized-image';
                var container = document.getElementById('profile-picture-preview');
                if (container) {
                    container.innerHTML = '';
                    container.appendChild(img);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    }

    // Organization logo preview (keep this if you have it)
    var logoInput = document.getElementById('logo');
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'org-logo standardized-image';
                var container = document.getElementById('logo-preview');
                if (container) {
                    container.innerHTML = '';
                    container.appendChild(img);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    }
});

function validateForm(form) {
    let isValid = true;
    form.querySelectorAll('input, textarea, select').forEach(field => {
        if (field.hasAttribute('required') && !field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            let errorMessage = field.nextElementSibling;
            if (!errorMessage || !errorMessage.classList.contains('error-message')) {
                errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                field.parentNode.insertBefore(errorMessage, field.nextSibling);
            }
            errorMessage.textContent = 'This field is required.';
        } else {
            field.classList.remove('error');
            let errorMessage = field.nextElementSibling;
            if (errorMessage && errorMessage.classList.contains('error-message')) {
                errorMessage.remove();
            }
        }
    });
    return isValid;
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    
    const container = document.getElementById('toast-container');
    if (!container) {
        const newContainer = document.createElement('div');
        newContainer.id = 'toast-container';
        document.body.appendChild(newContainer);
    }
    
    document.getElementById('toast-container').appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}