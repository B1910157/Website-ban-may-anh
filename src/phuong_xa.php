<?php

namespace CT275\Labs;

class  phuong_xa
{
	private $db;

	private $id = -1;
	
	public $px_ten;
    public $qh_id;
	
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['px_ten'])) {
			$this->px_ten = trim($data['px_ten']);
		}
        if (isset($data['qh_id'])) {
			$this->category_id = trim($data['qh_id']);
		}
		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->px_ten) {
			$this->errors['px_ten'] = 'Invalid ten phuong xa sai.';
		}
        if (!$this->qh_id) {
			$this->errors['qh_id'] = 'Invalid quan huyen khong hop le.';
		}
		return empty($this->errors);
	}
	public function all()
	{
		$phuong_xas = [];
		$stmt = $this->db->prepare('select * from phuong_xa');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$phuong_xa = new phuong_xa($this->db);
			$phuong_xa->fillFromDB($row);
			$phuong_xas[] = $phuong_xa;
		}
		return $phuong_xas;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'px_ten' => $this->px_ten,
            'qh_id' => $this->qh_id
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update phuong_xa set px_ten= :px_ten, qh_id= :qh_id
where id = :id');
			$result = $stmt->execute([
				'px_ten' => $this->px_ten,
                'qh_id' => $this->qh_id,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into phuong_xa (px_ten, qh_id)
values (:px_ten, :qh_id)'
			);
			$result = $stmt->execute([
				'px_ten' => $this->px_ten,
                'qh_id' => $this->qh_id
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from phuong_xa where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function update(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from phuong_xa where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
