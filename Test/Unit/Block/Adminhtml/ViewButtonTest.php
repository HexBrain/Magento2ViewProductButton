<?php
namespace HexBrain\ProductView\Test\Unit\Block\Adminhtml\ViewButtonTest;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class ViewButtonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \HexBrain\ProductView\Block\Adminhtml\ViewProductButton
     */
    protected $model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $productMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $emulationMock;

    protected function setUp()
    {
        $this->productMock = $this->getMock('\Magento\Catalog\Model\Product', [], [], '', false);
        $this->productMock->expects($this->any())->method('getId')->willReturn(1);
        $this->productMock->expects($this->any())->method('loadByAttribute')->willReturn($this->productMock);
        $this->productMock->expects($this->any())->method('getProductUrl')->willReturn('test');

        $buttonList = $this->getMock('\Magento\Backend\Block\Widget\Button\ButtonList', [], [], '', false);
        $buttonList->expects($this->once())->method('add')->willReturn(0);

        $this->registryMock = $this->getMock('\Magento\Framework\Registry', [], [], '', false);
        $this->registryMock->expects($this->any())->method('registry')->willReturn($this->productMock);

        $this->requestMock = $this->getMockForAbstractClass(
            'Magento\Framework\App\RequestInterface',
            [],
            '',
            false,
            true,
            true,
            ['getParam']
        );
        $this->requestMock->expects($this->any())->method('getParam')->willReturn(0);

        $this->emulationMock = $this->getMock('\Magento\Store\Model\App\Emulation', [], [], '', false);

        $contextMock = $this->getMock('\Magento\Backend\Block\Widget\Context', [], [], '', false);
        $contextMock->expects($this->any())->method('getRequest')->willReturn($this->requestMock);
        $contextMock->expects($this->any())->method('getButtonList')->willReturn($buttonList);

        $this->model = (new ObjectManager($this))->getObject(
            'HexBrain\ProductView\Block\Adminhtml\ViewProductButton',
            [
                'context' => $contextMock,
                'registry' => $this->registryMock,
                'product' => $this->productMock,
                'request' => $this->requestMock,
                'emulation' => $this->emulationMock
            ]
        );
    }

    public function testGetButtonData()
    {
        $data = [
            'label' => __('View'),
            'class' => 'view disable',
            'on_click' => 'window.open(\'test\')',
            'sort_order' => 20,
        ];
        $this->assertEquals($data, $this->model->getButtonData());
    }
}
