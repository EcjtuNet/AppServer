<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    public function testLogin()
    {
        $this->visit('/admin')
            ->see('请登录');
        $this->visit('/admin/dashboard')
            ->see('请登录');
        $this->visit('/admin/login')
            ->type('admin', 'username')
            ->type('admin', 'password')
            ->press('登录')
            ->seePageIs('/admin/dashboard');
    }
    public function testView()
    {
        $this->withoutMiddleware();

        $this->visit('/admin/dashboard')
            ->see('调用信息');
        $this->visit('/admin/article')
            ->see('文章信息');
        $this->visit('/admin/comment')
            ->see('评论管理');
        $this->visit('/admin/push')
            ->see('推送信息');
        $this->visit('/admin/category')
            ->see('分类信息');
        $this->visit('/admin/feedback')
            ->see('意见反馈');
        $this->visit('/admin/setting')
            ->see('设置信息');
    }
    public function testDashboard()
    {
        $log = factory(App\Log::class)->make([
            'type' => 'api',
            'content' => 'api/index'
            ]);
        $this->withSession(['admin' => 'admin'])
            ->visit('/admin/dashboard')
            ->see('api/index');
    }
    public function testArticle()
    {
        $this->withSession(['admin' => 'admin'])
            ->visit('/admin/article')
            ->click('新建文章')
            ->seePageIs('/admin/article/new')
            ->see('标题');
        $this->visit('/admin/article/new')
            ->type('测试标题', 'title')
            ->type('测试描述', 'info')
            ->check('categories[1]')
            ->type('测试内容', 'content')
            ->press('提交')
            ->seePageIs('/admin/article/1');
        $this->visit('/admin/article/1')
            ->see('测试标题')
            ->see('测试内容');
        $this->visit('/admin/article/1')
            ->click('编辑文章')
            ->seePageIs('/admin/article/1/edit')
            ->see('测试标题')
            ->see('测试内容')
            ->see('测试描述');
        $this->visit('/admin/article/1/edit')
            ->type('修改后的内容', 'content')
            ->press('提交')
            ->seePageIs('/admin/article/1')
            ->see('修改后的内容');
        $this->visit('/admin/article')
            ->see('发布')
            ->click('发布')
            ->see('取消发布');
        $this->visit('/admin/article')
            ->click('删除')
            ->dontSee('/delete');
    }
}
