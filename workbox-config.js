module.exports = {
	globDirectory: 'CSS/',
	globPatterns: [
		'**/*.css'
	],
	swDest: 'CSS/sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};