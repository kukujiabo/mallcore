<?php
namespace App\Service\Organization;

use App\Service\BaseService;
use Core\Service\CurdSv;

class DesignerSv extends BaseService {

	const LIST_FIELDS = [
		'a.name',
		'a.title',
		'a.phone',
		'a.org_id',
		'a.illumination',
		'a.email',
		'a.wechat',
		'a.perception',
		'a.hornor',
		'a.created_at',
		'b.org_name'
	];
	
	public function create($options) {
		$data = [
			'illumination' => $options['illumination'],
			'name' => $options['name'],
			'title' => $options['title'],
			'phone' => $options['phone'],
			'org_id' => $options['org_id'],
			'email' => $options['email'],
			'wechat' => $options['wechat'],
			'perception' => $options['perception'],
			'hornor' => $options['hornor'],
			'sort' => $options['sort'],
			'created_at' => date('Y-m-d H:i:s')
		];
		return $this->add($options);
	}

	public function getList($options) {
		$query = [];
		$fields = $options['fields'] ? $options['fields'] : implode(',', SELF::LIST_FIELDS);
		$sql .= " SELECT {$fields} FROM designer a LEFT JION organization b ON a.org_id = b.id WHERE  1=1 ";
		if ($options['name']) {
			$query['name'] = $options['name'];
			$sql .= " name LIKE '%?%' ";
		}
		if ($options['title']) {
			$query['title'] = $options['title'];
			$sql .= " title LIKE '%?%' ";
		}
		if ($options['org_id']) {
			$query['org_id'] = $options['org_id'];
			$sql .= " org_id = ? ";
		}
		$total = $this->queryCount($query);
		$offset = ($options['page'] - 1) * $options['page_size'];
		$order = $options['order'] ? $options['order'] : ' sort DESC ';
		$sql .= " ORDER BY {$order} LIMIT {$offset}, {$options['page_size']} ";
		$list = $this->modelInst()->queryAll($sql, $query);
		return [ 'list' => $list, 'total' => $total ];
	}

	public function getDetail($options) {
		$detail = $this->findOne($options['id']);
		if ($detail['org_id']) {
			$osv = new OrganizationSv();
			$detail['org_info'] = $osv->findOne($detail['org_id']);
		}
		return $detail;
	}

	public function edit($options) {
		$id = $options['id'];
		$updateData = [];
		if ($options['illumination']) {
			$updateData = $options['illumination'];
		}
		if ($options['name']) {
			$updateData = $options['name'];
		}
		if ($options['title']) {
			$updateData = $options['title'];
		}
		if ($options['phone']) {
			$updateData = $options['phone'];
		}
		if ($options['org_id']) {
			$updateData = $options['org_id'];
		}
		if ($options['email']) {
			$updateData = $options['email'];
		}
		if ($options['wechat']) {
			$updateData = $options['wechat'];
		}
		if ($options['perception']) {
			$updateData = $options['perception'];
		}
		if ($options['hornor']) {
			$updateData = $options['hornor'];
		}
		if ($options['sort']) {
			$updateData = $options['sort'];
		}
		return $this->update($id, $updateData);
	}

}