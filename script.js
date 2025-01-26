document.addEventListener('DOMContentLoaded', function() {
  // Handle hotel delete confirmation
  document.querySelectorAll('form.cancel-booking-form').forEach(form => {
      form.addEventListener('submit', function(event) {
          const confirmed = confirm('Are you sure you want to cancel this booking?');
          if (!confirmed) {
              event.preventDefault();
          }
      });
  });
});



