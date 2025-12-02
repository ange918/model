let currentStep = 1;
const totalSteps = 4;

function nextStep() {
    if (validateStep(currentStep)) {
        if (currentStep < totalSteps) {
            currentStep++;
            updateForm();
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateForm();
    }
}

function updateForm() {
    document.querySelectorAll('.form-step').forEach(step => {
        step.classList.remove('active');
    });
    
    document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
    
    document.querySelectorAll('.progress-step').forEach((step, index) => {
        if (index + 1 < currentStep) {
            step.classList.add('completed');
            step.classList.remove('active');
        } else if (index + 1 === currentStep) {
            step.classList.add('active');
            step.classList.remove('completed');
        } else {
            step.classList.remove('active', 'completed');
        }
    });
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep(step) {
    const currentFormStep = document.querySelector(`.form-step[data-step="${step}"]`);
    const requiredFields = currentFormStep.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '#ddd';
        }
    });
    
    if (!isValid) {
        alert('Veuillez remplir tous les champs obligatoires');
    }
    
    return isValid;
}

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        
        reader.readAsDataURL(file);
    }
}

document.getElementById('inscriptionForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (validateStep(currentStep)) {
        const formData = new FormData(this);
        
        alert('Merci pour votre candidature ! Nous vous contacterons très bientôt.');
        
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 2000);
    }
});
