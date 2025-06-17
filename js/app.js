// Application state
let currentSection = 'home';

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    setupEventListeners();
});

function initializeApp() {
    // Initialize database and load members
    fetch('/api/init', { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Database initialized successfully');
            }
        })
        .catch(error => {
            console.error('Error initializing database:', error);
        });
}

function setupEventListeners() {
    // Registration form
    const registrationForm = document.getElementById('registration-form');
    registrationForm.addEventListener('submit', handleRegistration);

    // Search form
    const searchForm = document.getElementById('search-form');
    searchForm.addEventListener('submit', handleSearch);

    // Update form
    const updateForm = document.getElementById('update-form');
    updateForm.addEventListener('submit', handleUpdate);
}

// Navigation functions
function showHome() {
    showSection('home');
}

function showMembers() {
    showSection('members');
    loadMembers();
}

function showUpdate() {
    showSection('update');
    document.getElementById('update-form-container').style.display = 'none';
}

function showSection(sectionName) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Show selected section
    const targetSection = document.getElementById(`${sectionName}-section`);
    if (targetSection) {
        targetSection.classList.add('active');
        currentSection = sectionName;
    }
}

// Registration handling
async function handleRegistration(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const memberData = {
        firstName: formData.get('firstName'),
        lastName: formData.get('lastName'),
        birthDate: formData.get('birthDate') || null,
        city: formData.get('city'),
        state: formData.get('state')
    };

    try {
        const response = await fetch('/api/members', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(memberData)
        });

        const result = await response.json();
        
        if (result.success) {
            showMessage('Member registered successfully!', 'success');
            event.target.reset();
        } else {
            showMessage('Error registering member: ' + result.error, 'error');
        }
    } catch (error) {
        showMessage('Error registering member: ' + error.message, 'error');
    }
}

// Load and display members
async function loadMembers() {
    const membersContainer = document.getElementById('members-list');
    membersContainer.innerHTML = '<div class="loading">Loading family members...</div>';

    try {
        const response = await fetch('/api/members');
        const result = await response.json();
        
        if (result.success) {
            displayMembers(result.members);
        } else {
            membersContainer.innerHTML = '<div class="error">Error loading members: ' + result.error + '</div>';
        }
    } catch (error) {
        membersContainer.innerHTML = '<div class="error">Error loading members: ' + error.message + '</div>';
    }
}

function displayMembers(members) {
    const membersContainer = document.getElementById('members-list');
    
    if (members.length === 0) {
        membersContainer.innerHTML = '<div class="loading">No family members registered yet.</div>';
        return;
    }

    const membersHTML = members.map((member, index) => `
        <div class="member-card">
            <h3>Record ${index + 1}</h3>
            <div class="member-info">
                <p><strong>ID:</strong> ${member.id}</p>
                <p><strong>First Name:</strong> ${member.firstname}</p>
                <p><strong>Last Name:</strong> ${member.lastname}</p>
                <p><strong>Birth Date:</strong> ${member.birthdate || 'Not provided'}</p>
                <p><strong>City:</strong> ${member.city}</p>
                <p><strong>State:</strong> ${member.state}</p>
                <p><strong>Join Date:</strong> ${new Date(member.joindate).toLocaleDateString()}</p>
            </div>
        </div>
    `).join('');

    membersContainer.innerHTML = membersHTML;
}

// Search handling
async function handleSearch(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const searchId = formData.get('searchId');

    try {
        const response = await fetch(`/api/members/${searchId}`);
        const result = await response.json();
        
        if (result.success && result.member) {
            populateUpdateForm(result.member);
            document.getElementById('update-form-container').style.display = 'block';
        } else {
            showMessage('Member not found with ID: ' + searchId, 'error');
            document.getElementById('update-form-container').style.display = 'none';
        }
    } catch (error) {
        showMessage('Error searching for member: ' + error.message, 'error');
    }
}

function populateUpdateForm(member) {
    const form = document.getElementById('update-form');
    form.querySelector('input[name="id"]').value = member.id;
    form.querySelector('input[name="firstName"]').value = member.firstname;
    form.querySelector('input[name="lastName"]').value = member.lastname;
    form.querySelector('input[name="birthDate"]').value = member.birthdate || '';
    form.querySelector('input[name="city"]').value = member.city;
    form.querySelector('input[name="state"]').value = member.state;
}

// Update handling
async function handleUpdate(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const memberData = {
        id: formData.get('id'),
        firstName: formData.get('firstName'),
        lastName: formData.get('lastName'),
        birthDate: formData.get('birthDate') || null,
        city: formData.get('city'),
        state: formData.get('state')
    };

    try {
        const response = await fetch(`/api/members/${memberData.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(memberData)
        });

        const result = await response.json();
        
        if (result.success) {
            showMessage('Member updated successfully!', 'success');
            cancelUpdate();
        } else {
            showMessage('Error updating member: ' + result.error, 'error');
        }
    } catch (error) {
        showMessage('Error updating member: ' + error.message, 'error');
    }
}

function cancelUpdate() {
    document.getElementById('update-form-container').style.display = 'none';
    document.getElementById('search-form').reset();
    document.getElementById('update-form').reset();
}

// Utility functions
function showMessage(message, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = message;
    messageDiv.className = `message ${type}`;
    messageDiv.style.display = 'block';
    
    setTimeout(() => {
        messageDiv.style.display = 'none';
    }, 5000);
}