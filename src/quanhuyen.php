<?php

namespace CT275\Labs;

class  quanhuyen
{
	private $db;

	private $id = -1;
	
	public $qh_ten;
	
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
		if (isset($data['qh_ten'])) {
			$this->qh_ten = trim($data['qh_ten']);
		}
		

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->qh_ten) {
			$this->errors['qh_ten'] = 'Invalid ten quan huyen sai.';
		}
		return empty($this->errors);
	}
	public function all()
	{
		$quanhuyens = [];
		$stmt = $this->db->prepare('select * from quan_huyen');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$quanhuyen = new quanhuyen($this->db);
			$quanhuyen->fillFromDB($row);
			$quanhuyens[] = $quanhuyen;
		}
		return $quanhuyens;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'qh_ten' => $this->qh_ten
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update quan_huyen set qh_ten= :qh_ten
where id = :id');
			$result = $stmt->execute([
				'qh_ten' => $this->qh_ten,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into quan_huyen (qh_ten)
values (:qh_ten)'
			);
			$result = $stmt->execute([
				'qh_ten' => $this->qh_ten
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from quan_huyen where id = :id');
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
		$stmt = $this->db->prepare('delete from quan_huyen where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
