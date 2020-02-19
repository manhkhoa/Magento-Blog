<?php

namespace BP\News\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
// use BP\News\Helper\Data;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface {
	
	protected $helperData;

	public function _construct(Data $helperData){
		$this->helperData = $helperData;
	}

	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){
		$installer = $setup;

		$installer->startSetup();

		if(!$installer->tableExists('bp_news_post')){
			$table = $installer->getConnection()
				->newTable($installer->getTable('bp_news_post'))
				->addColumn('post_id', Table::TYPE_INTEGER, null, ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true], 'Post ID')
				->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false], 'Post Title')
				->addColumn('summary', Table::TYPE_TEXT, '64k', ['nullable' => true], 'Post Summary')
				->addColumn('body', Table::TYPE_TEXT, '64k', ['nullable' => false], 'Post Content')
				->addColumn('image', Table::TYPE_TEXT, 255, [], 'Post Image')
				->addColumn('published', Table::TYPE_INTEGER, 1, [], 'Post Status')
				->addColumn('url', Table::TYPE_TEXT, 255, [], 'Post URL')
				->addColumn('author', Table::TYPE_INTEGER, null, [], 'Post Author')
				->addColumn('changed', Table::TYPE_TIMESTAMP, null, [], 'Post updated date')
				->addColumn('created', Table::TYPE_TIMESTAMP, null, [], 'Post created date')
				->setComment('Post Table');

			$installer->getConnection()->createTable($table);
		}

		$installer->endSetup();
	}
}

