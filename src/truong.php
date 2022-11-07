<?php

namespace CT275\Labs;

class truong
{
	private $db;

	private $id = -1;
	
	public $truong_ten;
	
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
		if (isset($data['truong_ten'])) {
			$this->truong_ten = trim($data['truong_ten']);
		}
		

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->truong_ten) {
			$this->errors['truong_ten'] = 'Invalid truong_ten.';
		}
		return empty($this->errors);
	}
	public function all()
	{
		$truongs = [];
		$stmt = $this->db->prepare('select * from truong');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$truong = new truong($this->db);
			$truong->fillFromDB($row);
			$truongs[] = $truong;
		}
		return $truongs;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'truong_ten' => $this->truong_ten
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update truong set truong_ten= :truong_ten
where id = :id');
			$result = $stmt->execute([
				'truong_ten' => $this->truong_ten,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into truong (truong_ten)
values (:truong_ten)'
			);
			$result = $stmt->execute([
				'truong_ten' => $this->truong_ten
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from truong where id = :id');
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
		$stmt = $this->db->prepare('delete from truong where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
