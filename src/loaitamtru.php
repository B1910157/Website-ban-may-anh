<?php

namespace CT275\Labs;

class loaitamtru
{
	private $db;

	private $id = -1;
	
	public $tenloai;
	
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
		if (isset($data['tenloai'])) {
			$this->tenloai = trim($data['tenloai']);
		}
		

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->tenloai) {
			$this->errors['tenloai'] = 'Invalid tenloai.';
		}
		return empty($this->errors);
	}
	public function all()
	{
		$loaitamtrus = [];
		$stmt = $this->db->prepare('select * from loaitamtru');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$loaitamtru = new loaitamtru($this->db);
			$loaitamtru->fillFromDB($row);
			$loaitamtrus[] = $loaitamtru;
		}
		return $loaitamtrus;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'tenloai' => $this->tenloai
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update loaitamtru set tenloai= :tenloai
where id = :id');
			$result = $stmt->execute([
				'tenloai' => $this->tenloai,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into loaitamtru (tenloai)
values (:tenloai)'
			);
			$result = $stmt->execute([
				'tenloai' => $this->tenloai
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from loaitamtru where id = :id');
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
		$stmt = $this->db->prepare('delete from loaitamtru where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
