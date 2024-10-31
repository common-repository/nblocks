/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps ,InspectorControls, __experimentalBlockVariationPicker as BlockVariationPicker, } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { PanelBody, SelectControl,BaseControl, __experimentalNumberControl as NumberControl, ToggleControl, DateTimePicker,Button,Dropdown } from '@wordpress/components';
import { more } from '@wordpress/icons';
import { npubIcons } from './npubicons';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

const fp_categories_list = (taxonomy) => {
	let catsList = [];
	let catData = wp.data.select('core').getEntityRecords('taxonomy', taxonomy);
	if(catData === null){
		return catsList;
	}
	catData.forEach(function(cat){
		catsList.push({value:cat.slug,label:cat.name});
	 });
	return catsList;
}

const fp_authors_list = () => {
	let authorsList = [];
	let authorData = wp.data.select('core').getUsers();
	if(authorData === null){
		return authorsList;
	}
	authorData.forEach(function(author){
		authorsList.push({value:author.id,label:author.name});
	 });
	return authorsList;
}

const variations = [{
    name: 'tiny-block-one',
    title: 'Small posts - 4 Column',
    icon: npubIcons['tinyblockone'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['tinyblockone'], ppp: 8 },
},{
    name: '3col-masonry',
    title: 'Medium - 3 Column',
    icon: npubIcons['medium3cols'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['medium3cols'], ppp: 6 },
},{
    name: '4col-masonry',
    title: 'Medium - 4 Column',
    icon: npubIcons['medium4cols'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['medium4cols'], ppp: 8 },
},{
    name: 'featured-big',
    title: 'Large - Featured',
    icon: npubIcons['largefeatured'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['largefeatured'], ppp: 1 },
},{
    name: 'featured-big-multiloop',
    title: 'Large - Featured with small posts',
    icon: npubIcons['largefeaturedmultiloop'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['largefeaturedmultiloop'], ppp: 7 },
},{
    name: 'sidebar-block',
    title: 'Sidebar - Medium posts, single column',
    icon: npubIcons['sidebarposts'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['sidebarposts'], ppp: 3 },
},{
    name: '5col-masonry',
    title: 'Text card - 4 column',
    icon: npubIcons['textcard4col'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['textcard4col'], ppp: 4 },
},{
    name: '3col-noimage',
    title: 'Text card - 3 column',
    icon: npubIcons['textcard3col'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['textcard3col'], ppp: 6 },
},{
    name: 'full-row',
    title: 'Large - Full row article',
    icon: npubIcons['largefullrow'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['largefullrow'], ppp: 10 },
},{
    name: 'center-image',
    title: 'Featured center',
    icon: npubIcons['featuredcenter'],
    scope: [ 'block' ],
    attributes: { icon: npubIcons['featuredcenter'], ppp: 5 },
}];


const isEditingWidget = () => {
	return window.location.pathname.includes('widgets.php');
}	

const blockName = 'sidebar-block';
const blocknameIndex = variations.findIndex(item => item.name === blockName);

if (blocknameIndex !== -1 && ! isEditingWidget()) {
  variations.splice(blocknameIndex, 1);
}


export default function Edit(props) {
	const {
		attributes: {
			categories,offset,ppp,hideExcerpt,hideCattext,hideDate,hideAuth,author,date,order,orderBy,layout
		},
		setAttributes,
		className,
	  } = props;

	  // Handle variation selection
	const onVariationSelect = (variation) => {
		// Update attributes based on the selected variation
		setAttributes({ ppp: variation.attributes.ppp });
		setAttributes({ layout : variation.name })
	};
	
	  if ( ! props.attributes.layout ) {
		return (
			<div { ...useBlockProps() }>
				<BlockVariationPicker
					variations={ variations }
					className="nblock_panel"
					label="Article Layout"
					value={layout}
					onSelect={ onVariationSelect }
				/>
			</div>
		);
	}

	return (
		<div className="filtered_post">
			 <InspectorControls key="setting">
			 		<PanelBody title="Filter Settings" icon={ more } initialOpen={ true }>
						<SelectControl
							multiple
							className="filtered_post_ins_ms"
							label={ __( 'Select Categories' ) }
							help={ __( 'Press ctr and select multiple categories' ) }
							value={ categories } // e.g: value = [ 'a', 'c' ]
							onChange={ value => setAttributes({ categories : value }) }
							options={ fp_categories_list('category') }
						/>
						 <BaseControl id="numner-control-1" label="Post offset" help="Post will start to listing after selected numner.">
							<NumberControl
								className="filtered_post_offsel_controll"
								isShiftStepEnabled={ true }
								onChange={ value => setAttributes({ offset : parseInt(value) })  }
								shiftStep={ 1 }
								value={ parseInt(offset) }
							/>
						</BaseControl>
						<BaseControl id="numner-control-2" label="Post Limit" help="Select -1 if you want to list all posts.">
							<NumberControl
								className="filtered_post_offsel_control_2"
								isShiftStepEnabled={ true }
								onChange={ value => setAttributes({ ppp : parseInt(value) })  }
								shiftStep={ 1 }
								value={ parseInt(ppp) }
							/>
						</BaseControl>
						<SelectControl
							multiple
							className="filtered_post_ins_ms"
							label={ __( 'Select Authors' ) }
							help={ __( 'Press ctr and select multiple authors' ) }
							value={ author } // e.g: value = [ 'a', 'c' ]
							onChange={ value => setAttributes({ author : value })  }
							options={ fp_authors_list() }
						/>
						 <Dropdown
							className="filtered_posts_custom"
							contentClassName="my-popover-content-classname"
							position="bottom right"
							renderToggle={ ( { isOpen, onToggle } ) => (
								<div className="fb_post_slection">
                				<p>Post will be display which are published after selected below date.</p>
								<Button
									variant="primary"
									onClick={ onToggle }
									aria-expanded={ isOpen }
									focus={true}
									className="filtered_posts_custom_button"
								>
									Select Date
								</Button>
								</div>
							) }
							renderContent={ () => <DateTimePicker
								label={ __( 'Select Date' ) }
							   currentDate={ date }
							   value={ date }
							   onChange={ value => setAttributes({ date : value }) }
							   is12Hour={ true }
						   /> }
						/>
						<SelectControl
							label={ __( 'Order By' ) }
							value={ orderBy } // e.g: value = [ 'a', 'c' ]
							onChange={ value => setAttributes({ orderBy : value }) }
							options={ [
								{ value: '', label: '--Select--'},
								{ value: 'date', label: 'Date'},
								{ value:'title', label:'Title' }
							] }
						/>
						{ orderBy == 'date' && <SelectControl
							label={ __( 'Order' ) }
							value={ order } // e.g: value = [ 'a', 'c' ]
							onChange={ value => setAttributes({ order : value }) }
							options={ [
								{ value: 'ASC', label: 'asc' },
								{ value:'DESC', label: 'desc' }
							] }
						/> }

						{ orderBy == 'title' && <SelectControl
							label={ __( 'Order' ) }
							value={ order } // e.g: value = [ 'a', 'c' ]
							onChange={ value => setAttributes({ order : value }) }
							options={ [
								{ value: 'ASC', label: 'a-z' },
								{ value:'DESC', label: 'z-a' }
							] }
						/> }
						
					</PanelBody>
					<PanelBody title="Content Settings" icon={ more } initialOpen={ true }>
						{ (layout == 'featured-big' || layout == 'featured-big-multiloop' || layout == '3col-masonry' || layout == 'sidebar-block' || layout == 'full-row' || layout == 'center-image' ) && <ToggleControl
								label="Hide Excerpt"
								help={
									hideExcerpt
										? 'Show Excerpt.'
										: 'Hide Excerpt.'
								}
								checked={ hideExcerpt }
								onChange={ value => setAttributes({ hideExcerpt : value }) }
							/>
						}
						<ToggleControl
							label="Hide Category"
							help={
								hideCattext
									? 'Show Category.'
									: 'Hide Category.'
							}
							checked={ hideCattext }
							onChange={ value => setAttributes({ hideCattext : value }) }
						/>
						{ layout != 'tiny-block-one' && layout != '3col-noimage' && layout != '5col-masonry' &&  <ToggleControl
								label="Hide Date"
								help={
									hideDate
										? 'Show Date.'
										: 'Hide Date.'
								}
								checked={ hideDate }
								onChange={ value => setAttributes({ hideDate : value }) }
							/>
						}
						{ layout != 'tiny-block-one' && layout != '3col-noimage' && layout != '5col-masonry' && <ToggleControl
								label="Hide Author"
								help={
									hideAuth
										? 'Show Author.'
										: 'Hide Author.'
								}
								checked={ hideAuth }
								onChange={ value => setAttributes({ hideAuth : value }) }
							/>
						}
					</PanelBody>
			 </InspectorControls> 
			 <div {...useBlockProps()}>
				<ServerSideRender
					block="nblock/post-filter"
					attributes={{
						...props.attributes,
						className: className, // Pass className as an attribute
					}}
				/>  
			</div>
		</div>
	);
}
