(function () {
	if (!window.wp || !wp.plugins || !wp.editPost || !wp.element || !wp.components || !wp.data) {
		return;
	}

	const { registerPlugin } = wp.plugins;
	const { PluginDocumentSettingPanel } = wp.editPost;
	const { ToggleControl } = wp.components;
	const { useSelect, useDispatch } = wp.data;
	const { createElement: el } = wp.element;

	const PageTitleSettingPanel = () => {
		const postType = useSelect((select) => select('core/editor').getCurrentPostType());
		const meta = useSelect((select) => select('core/editor').getEditedPostAttribute('meta') || {});
		const { editPost } = useDispatch('core/editor');

		// Only render for pages and posts
		if (postType !== 'page' && postType !== 'post') {
			return null;
		}

		// If unset (''), default to true. If explicitly '0', false.
		const isTitleVisible = meta._mrkwp_show_title !== '0';

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'mrkwp-page-title-settings',
				title: 'Page Title',
				icon: 'visibility',
			},
			el(ToggleControl, {
				label: 'Show Page Title',
				help: isTitleVisible ? 'Title is displayed above the content.' : 'Title is hidden on the frontend.',
				checked: isTitleVisible,
				onChange: (value) => {
					editPost({
						meta: {
							...meta,
							_mrkwp_show_title: value ? '1' : '0',
						},
					});
				},
			})
		);
	};

	registerPlugin('mrkwp-page-title-settings', {
		render: PageTitleSettingPanel,
		icon: 'visibility',
	});
})();
