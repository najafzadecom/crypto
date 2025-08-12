/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

// Common List Page Functions
class ListPageManager {
    constructor() {
        this.init();
    }

    init() {
        this.initializeAdvancedFilters();
        this.bindEvents();
        this.initializeDeleteConfirmation();
    }

    // Initialize advanced filters visibility based on filled inputs
    initializeAdvancedFilters() {
        document.addEventListener('DOMContentLoaded', () => {
            // Check if any advanced filters are filled and show advanced filters if needed
            // This will be configured per page via data attributes or specific input lists
            const advancedFiltersContainer = document.getElementById('advancedFilters');
            if (!advancedFiltersContainer) return;

            const advancedInputs = advancedFiltersContainer.querySelectorAll('input, select');
            let hasAdvancedFilters = false;

            advancedInputs.forEach(input => {
                if (input.value && input.value !== '') {
                    hasAdvancedFilters = true;
                }
            });

            if (hasAdvancedFilters) {
                advancedFiltersContainer.style.display = 'block';
            }
        });
    }

    bindEvents() {
        // Auto-submit on select change for better UX
        document.addEventListener('change', (e) => {
            if (e.target.tagName === 'SELECT' && e.target.closest('#searchForm')) {
                document.getElementById('searchForm').submit();
            }
        });

        // Handle sorting clicks to preserve form filters
        document.addEventListener('click', (e) => {
            const sortLink = e.target.closest('th a[href*="sort="]');
            if (sortLink) {
                e.preventDefault();

                // Get current form data
                const formData = new FormData(document.getElementById('searchForm'));
                const params = new URLSearchParams(formData);

                // Extract sort parameters from the clicked link
                const url = new URL(sortLink.href);
                const sort = url.searchParams.get('sort');
                const direction = url.searchParams.get('direction');

                // Add sort parameters to existing form params
                params.set('sort', sort);
                params.set('direction', direction);

                // Navigate to the new URL with all parameters
                window.location.href = window.location.pathname + '?' + params.toString();
            }
        });
    }

    // Initialize delete confirmation functionality
    initializeDeleteConfirmation() {
        document.addEventListener('click', (e) => {
            const deleteButton = e.target.closest('[data-delete-url]');
            if (deleteButton) {
                e.preventDefault();
                const deleteUrl = deleteButton.getAttribute('data-delete-url');
                const itemName = deleteButton.getAttribute('data-item-name') || 'bu elementi';

                this.showDeleteConfirmation(deleteUrl, itemName);
            }
        });
    }

    // Show delete confirmation modal using SweetAlert2
    showDeleteConfirmation(deleteUrl, itemName) {
        // Initialize SweetAlert2
        const swalInit = Swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light',
                denyButton: 'btn btn-light'
            }
        });

        swalInit.fire({
            title: 'Əminsiniz?',
            text: `${itemName} silmək istədiyinizə əminsiniz? Bu əməliyyat geri alına bilməz.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Bəli, sil!',
            cancelButtonText: 'Xeyr, ləğv et',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                swalInit.fire({
                    title: 'Silinir...',
                    text: 'Zəhmət olmasa gözləyin',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request instead of form submit
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const formData = new FormData();
                formData.append('_token', csrfToken ? csrfToken.getAttribute('content') : '');
                formData.append('_method', 'DELETE');
                formData.append('confirmed', '1');

                fetch(deleteUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    return response.json().then(data => {
                        if (response.ok) {
                        // Success - show success message and reload page
                            swalInit.fire({
                                title: 'Uğurla silindi!',
                                text: data.message || 'Element uğurla silindi',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            }).then(() => {
                                // Reload the page to update the list
                                window.location.reload();
                            });
                        } else {
                            // Error - show error message
                            swalInit.fire({
                                title: 'Xəta!',
                                text: data.message || 'Silmə zamanı xəta baş verdi',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    swalInit.fire({
                        title: 'Xəta!',
                        text: 'Silmə zamanı xəta baş verdi',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                });
            }
        });
    }
}

// Common utility functions for list pages
function toggleAdvancedFilters() {
    const advancedFilters = document.getElementById('advancedFilters');
    if (advancedFilters.style.display === 'none' || advancedFilters.style.display === '') {
        advancedFilters.style.display = 'block';
    } else {
        advancedFilters.style.display = 'none';
    }
}

function clearFilters() {
    // Clear all form inputs
    document.getElementById('searchForm').reset();

    // Hide advanced filters
    document.getElementById('advancedFilters').style.display = 'none';

    // Submit form to remove URL parameters
    window.location.href = window.location.pathname;
}

function changeLimit(limit) {
    // Get current form data
    const formData = new FormData(document.getElementById('searchForm'));
    const params = new URLSearchParams(formData);

    // Add limit parameter
    params.set('limit', limit);

    // Navigate to the new URL with all parameters
    window.location.href = window.location.pathname + '?' + params.toString();
}

// Currency symbols utility
const currencySymbols = {
    'TRY': '₺',
    'USD': '$',
    'EUR': '€',
    'GBP': '£'
};

// Format amount with currency symbol
function formatAmountWithCurrency(amount, currency) {
    const symbol = currencySymbols[currency] || '';
    return `${symbol} ${parseFloat(amount).toFixed(2)}`;
}

// Modal handling for show details
function initializeShowModal() {
    const showModal = document.getElementById('show_modal');
    if (!showModal) return;

    showModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-url');

        fetch(url)
            .then(response => response.json())
            .then(responseData => {
                const data = responseData.item;

                // Populate modal fields based on data attributes
                Object.keys(data).forEach(key => {
                    const element = document.getElementById(key.replace(/_/g, '-'));
                    if (element) {
                        if (key.endsWith('_html') || key === 'status_html' || key === 'coloredName' || key === 'coloredRoleNames') {
                            element.innerHTML = data[key] ?? '-';
                        } else if (key === 'roles' && Array.isArray(data[key])) {
                            element.innerText = data[key].map(role => role.name).join(', ') || '-';
                        } else if (key === 'created_at' || key === 'updated_at') {
                            element.innerText = data[key] ? new Date(data[key]).toLocaleString() : '-';
                        } else if (key === 'image' && data[key]) {
                            // Special handling for image fields - show as image if URL exists
                            const imageUrl = data[key];
                            if (imageUrl && imageUrl !== '-' && imageUrl.trim() !== '') {
                                element.innerHTML = `<img src="${imageUrl}" alt="Image" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`;
                            } else {
                                element.innerText = '-';
                            }
                        } else if (key === 'image_url' && data[key]) {
                            // Special handling for image_url fields - show as image if URL exists
                            const imageUrl = data[key];
                            if (imageUrl && imageUrl !== '-' && imageUrl.trim() !== '') {
                                element.innerHTML = `<img src="${imageUrl}" alt="Bank Logo" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">`;
                            } else {
                                element.innerText = '-';
                            }
                        } else {
                            element.innerText = data[key] ?? '-';
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
}

// Initialize the list page manager
document.addEventListener('DOMContentLoaded', () => {
    new ListPageManager();
    initializeShowModal();
});
