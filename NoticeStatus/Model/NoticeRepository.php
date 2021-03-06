<?php

namespace Codelegacy\NoticeStatus\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\AbstractModel;
use Codelegacy\NoticeStatus\Api\Data\NoticeInterface;
use Codelegacy\NoticeStatus\Api\NoticeRepositoryInterface;
use Codelegacy\NoticeStatus\Model\ResourceModel\Notice as NoticeResource;

class NoticeRepository implements NoticeRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];

    /**
     * @var NoticeResource
     */
    protected $_resource;

    /**
     * auto generated class
     * @var NoticeFactory
     */
    protected $_factory;

    /**
     * @param NoticeResource $resource
     * @param NoticeFactory $factory
     */
    public function __construct(
        NoticeResource $resource,
        NoticeFactory $factory
    ) {
        $this->_resource = $resource;
        $this->_factory = $factory;
    }

    /**
     * Save data.
     *
     * @param NoticeInterface $object
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function save(NoticeInterface $object)
    {
        /** @var NoticeInterface|AbstractModel $object */
        try {
            $this->_resource->save($object);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the record: %1', $exception->getMessage()));
        }
        return $object;
    }

    /**
     * Retrieve data.
     *
     * @param int $id
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function getById($id)
    {
        if (!isset($this->_instances[$id])) {
            /** @var NoticeInterface|AbstractModel $object */
            $object = $this->create();
            $this->_resource->load($object, $id);
            if (!$object->getId()) {
                throw new NoSuchEntityException();
            }
            $this->_instances[$id] = $object;
        }
        return $this->_instances[$id];
    }

    /**
     * Delete data.
     *
     * @param NoticeInterface $object
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(NoticeInterface $object)
    {
        /** @var NoticeInterface|AbstractModel $object */
        $id = $object->getId();
        try {
            unset($this->_instances[$id]);
            $this->_resource->delete($object);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove %1', $id));
        }
        unset($this->_instances[$id]);
        return true;
    }

    /**
     * Delete data by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @throws NoSuchEntityException
     * @return NoticeInterface
     */
    public function getObjectByParams($recordId, $recordType, $type)
    {
        $data = $this->getArrayByParams($recordId, $recordType, $type);
        if (!$data) {
            throw new NoSuchEntityException();
        }
        $model = $this->create($data);
        return $model;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @throws NoSuchEntityException
     * @return array
     */
    public function getArrayByParams($recordId, $recordType, $type)
    {
        $data = $this->_resource->getByParams($recordId, $recordType, $type);
        if (!$data) {
            throw new NoSuchEntityException();
        }
        return $data;
    }

    /**
     * @param array $data
     * @return NoticeInterface
     */
    public function create(array $data = [])
    {
        return $this->_factory->create(['data' => $data]);
    }
}