/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from '../block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata, {
	icon: {
		src: <svg width="198" height="198" viewBox="0 0 198 198" fill="none" xmlns="http://www.w3.org/2000/svg">
		<g clip-path="url(#clip0_1514_3730)">
		<rect width="198" height="198" fill="white"/>
		<rect x="-30" y="102.141" width="182.58" height="182.58" rx="73" transform="rotate(-46.3642 -30 102.141)" fill="url(#paint0_linear_1514_3730)"/>
		<path d="M99.1007 158.563L41.897 104.02L61.2456 83.7278L67.0553 89.2673C67.0415 84.5839 67.9369 79.9537 69.7414 75.3767C71.5087 70.7641 74.124 66.6417 77.5873 63.0094C81.7574 58.6359 86.4187 55.6859 91.5712 54.1596C96.7237 52.6332 101.932 52.5398 107.196 53.8794C112.458 55.1463 117.286 57.8749 121.681 62.065L158.048 96.74L138.699 117.033L106.69 86.5122C103.263 83.2453 99.662 81.616 95.8859 81.6243C92.0725 81.5971 88.6285 83.1957 85.5539 86.4203C83.4689 88.6071 82.1135 90.9235 81.4876 93.3695C80.8618 95.8154 80.9256 98.2467 81.6788 100.663C82.3948 103.044 83.777 105.211 85.8253 107.164L118.449 138.27L99.1007 158.563Z" fill="white"/>
		</g>
		<defs>
		<linearGradient id="paint0_linear_1514_3730" x1="143.406" y1="115.135" x2="-131.022" y2="376.796" gradientUnits="userSpaceOnUse">
		<stop stop-color="#B948FF"/>
		<stop offset="1" stop-color="#0057FF"/>
		</linearGradient>
		<clipPath id="clip0_1514_3730">
		<rect width="198" height="198" fill="white"/>
		</clipPath>
		</defs>
		</svg>		
	},
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
});
