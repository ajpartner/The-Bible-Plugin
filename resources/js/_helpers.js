/**
 * Checks if the document has finished loading and calls the provided callback function when it does.
 *
 * @param {Function} callback - The callback function to invoke when the document is loaded.
 * @returns {void}
 */
export const loaded = function (callback) {
    if (document.readyState === 'complete') {
        callback();
    } else {
        document.onreadystatechange = function () {
            if (document.readyState === "complete") {
                callback();
            }
        }
    }
}

/**
 * Creates an array of numbers forming a range from start to end (inclusive)
 * with a specified step.
 *
 * @param {number} start - The starting number of the range.
 * @param {number} end - The ending number of the range.
 * @param {number} [step=1] - The step used to increment the range. Default is 1.
 * @returns {number[]} - An array of numbers within the specified range.
 */
export const range = function (start, end, step = 1) {
    let range = [];
    for (let i = start; i <= end; i += step) {
        range.push(i);
    }
    return range;
}

/**
 * Returns the lightest shade of a given color.
 *
 * @param {string} color - The color represented as a string in RGB format (e.g., 'rgb(255, 0, 0)').
 * @return {string} - The lightest shade of the given color as a string in RGB format (e.g., 'rgb(255, 255, 255)').
 */
export const lightestShade = function (color) {
    let rgb = color.match(/\d+/g).map(Number);

    // Ensure the length is always 3
    while (rgb.length < 3) {
        rgb.push(0);
    }

    const maxVal = Math.max(...rgb); // Find the maximum value among RGB components
    return `rgb(${rgb.map(val => Math.min(255, val + maxVal)).join(',')})`;
}

/**
 * Returns the darkest shade of a given color.
 *
 * @param {string} color - The color in RGB format ("rgb(255, 0, 0)").
 * @return {string} - The darkest shade of the given color in RGB format.
 */
export const darkestShade = function (color) {
    let rgb = color.match(/\d+/g).map(Number);

    // Ensure the length is always 3
    while (rgb.length < 3) {
        rgb.push(0);
    }

    const minVal = Math.min(...rgb); // Find the minimum value among RGB components
    return `rgb(${rgb.map(val => Math.max(0, val - minVal)).join(',')})`;
}