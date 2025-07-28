/**
 * Urgent Banner Dismissal - jQuery Version
 * Handles the functionality to dismiss the urgent banner and remember the dismissal
 */
jQuery(document).ready(function ($) {
  // Check if the banner exists on the page
  var $urgentBanner = $('#urgent-banner');

  // If no banner exists, exit early
  if ($urgentBanner.length === 0) {
    return;
  }

  // Check if the banner was previously dismissed
  var bannerDismissed = localStorage.getItem('urgentBannerDismissed');

  // If it was dismissed, hide it immediately
  if (bannerDismissed) {
    $urgentBanner.hide();
    // Add the hidden attribute for better accessibility
    $urgentBanner.attr('hidden', 'hidden');
  }

  // Find the close button
  var $closeButton = $urgentBanner.find('.urgent-banner-close');

  if ($closeButton.length === 0) {
    return;
  }

  // Add click event listener to the close button
  $closeButton.on('click', function () {
    $urgentBanner.hide();
    $urgentBanner.attr('hidden', 'hidden');

    // Store the dismissal in localStorage
    localStorage.setItem('urgentBannerDismissed', 'true');
  });
});
