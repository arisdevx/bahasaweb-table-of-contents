/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;
const { useSelect } = wp.data;
const { __ } = wp.i18n;
const { RawHTML } = wp.element;

/**
 * Register the Table of Contents block
 */
registerBlockType('bahasaweb/table-of-contents', {
    title: __('Table of Contents', 'bahasaweb-table-of-contents'),
    description: __('Automatically generate a table of contents from H2 headings', 'bahasaweb-table-of-contents'),
    category: 'bahasaweb',
    icon: 'list-view',
    keywords: [__('toc'), __('table of contents'), __('daftar isi'), __('heading')],
    attributes: {
        title: {
            type: 'string',
            default: 'Daftar isi'
        }
    },
    supports: {
        html: false,
        align: true
    },

    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title } = attributes;
        const blockProps = useBlockProps();

        // Get all blocks from the current post
        const blocks = useSelect((select) => {
            const editor = select('core/block-editor');
            return editor ? editor.getBlocks() : [];
        }, []);

        // Extract H2 headings from blocks
        const extractHeadings = (blocks) => {
            const headings = [];
            
            const processBlocks = (blockList) => {
                blockList.forEach(block => {
                    if (block.name === 'core/heading' && block.attributes.level === 2) {
                        const content = block.attributes.content || '';
                        const text = content.replace(/<[^>]*>/g, ''); // Strip HTML tags
                        const id = block.attributes.anchor || sanitizeTitle(text);
                        
                        if (text) {
                            headings.push({
                                id: id,
                                text: text,
                                level: 2
                            });
                        }
                    }
                    
                    // Process inner blocks recursively
                    if (block.innerBlocks && block.innerBlocks.length > 0) {
                        processBlocks(block.innerBlocks);
                    }
                });
            };
            
            processBlocks(blocks);
            return headings;
        };

        // Sanitize title to create ID
        const sanitizeTitle = (text) => {
            return text
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        };

        const headings = extractHeadings(blocks);

        return (
            <div {...blockProps}>
                <InspectorControls>
                    <PanelBody title={__('Settings', 'bahasaweb-table-of-contents')}>
                        <TextControl
                            label={__('Title', 'bahasaweb-table-of-contents')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                            help={__('The title displayed at the top of the table of contents', 'bahasaweb-table-of-contents')}
                        />
                    </PanelBody>
                </InspectorControls>

                <div className="bahasaweb-toc">
                    <h2>{title}</h2>
                    {headings.length > 0 ? (
                        <ul>
                            {headings.map((heading, index) => (
                                <li key={index}>
                                    <a href={`#${heading.id}`} data-level={heading.level}>
                                        {heading.text}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <p style={{ fontStyle: 'italic', color: '#666' }}>
                            {__('No H2 headings found. Add some H2 headings to your content to populate the table of contents.', 'bahasaweb-table-of-contents')}
                        </p>
                    )}
                </div>
            </div>
        );
    },

    save: function() {
        // Dynamic block - rendered via PHP
        return null;
    }
});
