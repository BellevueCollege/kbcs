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

  // If it wasn't dismissed, hide it immediately
  if (!bannerDismissed) {
    // Small delay to ensure page is ready for smooth animation
    setTimeout(function () {
      $urgentBanner.addClass('show');
      $urgentBanner.removeAttr('hidden');
    }, 100);
  } else {
    $urgentBanner.removeClass('show');
    $urgentBanner.hide();
  }

  // Find the close button
  var $closeButton = $urgentBanner.find('.urgent-banner-close');

  if ($closeButton.length === 0) {
    return;
  }

  // Add click event listener to the close button
  $closeButton.on('click', function () {
    $urgentBanner.removeClass('show');
    $urgentBanner.hide();

    // Store the dismissal in localStorage
    localStorage.setItem('urgentBannerDismissed', 'true');
  });
});
