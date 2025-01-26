document.querySelector('form').addEventListener('submit', function (e) {
    var locationName = document.getElementById('location_name').value;
    if (!locationName) {
        alert('Please enter a location name');
        e.preventDefault();
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Handle room delete confirmation
    document.querySelectorAll('form.delete-room-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            const confirmed = confirm('Are you sure you want to delete this room?');
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Handle hotel delete confirmation
    document.querySelectorAll('form.delete-hotel-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            const confirmed = confirm('Are you sure you want to delete this hotel?');
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
});


document.getElementById('image').addEventListener('change', function (event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (file && !validImageTypes.includes(file.type)) {
        alert('Please select a valid image file (JPEG, PNG, GIF).');
        fileInput.value = ''; // Clear the file input
    }
});

document.getElementById('addhotel').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];

    if (file && !validImageTypes.includes(file.type)) {
        alert('Please select a valid image file (JPEG, PNG, GIF).');
        event.preventDefault(); // Prevent form submission
    }
});
document.getElementById('addRoom').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];

    if (file && !validImageTypes.includes(file.type)) {
        alert('Please select a valid image file (JPEG, PNG, GIF).');
        event.preventDefault(); // Prevent form submission
    }
});

document.getElementById('addLocation').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];

    if (file && !validImageTypes.includes(file.type)) {
        alert('Please select a valid image file (JPEG, PNG, GIF).');
        event.preventDefault(); // Prevent form submission
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            const imageInputs = form.querySelectorAll('input[type="file"]');
            for (let input of imageInputs) {
                if (input.files.length > 0) {
                    const file = input.files[0];
                    if (!validImageTypes.includes(file.type)) {
                        alert('Please select a valid image file (JPEG, PNG, GIF).');
                        event.preventDefault();
                        return false;
                    }
                }
            }
        });
    });

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && !validImageTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF).');
                event.target.value = ''; // Clear the file input
            }
        });
    });
});



