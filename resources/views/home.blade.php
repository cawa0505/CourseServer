@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
            <div class="panel panel-default">
                <div class="panel-heading">初始化工作</div>
                <div class="panel-body">
                    <p>本系统只提供了课表的相关操作功能，</p>
                    <p>而涉及具体的学生信息以及课程信息则通过文件的形式导入到Mysql数据库中，</p>
                    <p>请仅在需要更新数据时进行此操作（不要重复导入数据）。</p>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>学生信息由 CourseServer\public\data\studentInfo.txt 文件提供</p>
                        <a class="btn btn-default" href="{{ route('studentInfo') }}" role="button">导入学生信息</a>
                    </li>
                    <li class="list-group-item">
                    @if(isset($initialStudents))
                        <div class="panel panel-default">
                            <div class="panel-heading">已有学生列表</div>
                            <div class="panel-body">
                                <table class="table table-striped task-table">
                                    <thead>
                                        <th>学号</th>
                                        <th>学生姓名</th>
                                        <th>学生密码</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($initialStudents as $initialStudent)
                                        <tr>
                                            <td class="table-text">
                                                <div>{{ $initialStudent->stuid }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialStudent->name }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialStudent->password }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    </li>

                    <li class="list-group-item">
                        <p>课程信息由 CourseServer\public\data\courseInfo.txt 文件提供</p>
                        <a class="btn btn-default" href="{{ route('courseInfo') }}" role="button">导入课程信息</a>
                    </li>
                    <li class="list-group-item">
                    @if(isset($initialCourses))
                        <div class="panel panel-default">
                            <div class="panel-heading">已有课程列表</div>
                            <div class="panel-body">
                                <table class="table table-striped task-table">
                                    <thead>
                                        <th>课程编号</th>
                                        <th>课程名称</th>
                                        <th>授课老师</th>
                                        <th>星期</th>
                                        <th>上课时间</th>
                                        <th>下课时间</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($initialCourses as $initialCourse)
                                        <tr>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->courseid }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->name }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->teacher }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->week }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->start }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $initialCourse->end }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif    
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">课表的录入</div>
                <div class="panel-body">
                    <p>输入学号及课程号，点击添加即为该学生添加一门课程</p>
                </div>
                <div class="panel-footer">
                    <form class="form-inline" method="POST" action="{{ route('add') }}">
                        <!-- laravel 默认开启了csrf验证，不是get请求的话需要验证csrf,即在表单里加个隐藏域 -->
                        <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"/> -->
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="stuid2">学号</label>
                            <input type="text" class="form-control" id="stuid2" name="stuid">
                        </div>
                        <div class="form-group">
                            <label for="courseid2">课程编号</label>
                            <input type="text" class="form-control" id="courseid2" name="courseid">
                        </div>
                        <button type="submit" class="btn btn-default">添加</button>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">课表的查询及删除</div>
                <div class="panel-body">
                    <p>本模块实现了两种查询模式</p>
                    <p>一是通过输入学号查询一位学生的所有课程，</p>
                    <p>二是通过输入课程编号查询一门课程的所有学生。</p>
                </div>
                <!-- List group -->
                <ul class="list-group">

                    <li class="list-group-item">
                        <form class="form-inline" action="{{ route('queryStuid') }}" method="POST">
                            {{ csrf_field() }}
                            <label for="stuid">学号</label>
                            <input type="text" class="form-control" id="stuid" name="stuid">
                            <button type="submit" class="btn btn-default">查询</button>
                        </form>
                    </li>
                    <li class="list-group-item">
                    @if (session('courses'))
                        <div class="panel panel-default">
                            <div class="panel-heading">课程列表</div>
                            <div class="panel-body">
                                <table class="table table-striped task-table">
                                    <!-- Table Headings -->
                                    <thead>
                                        <th>课程编号</th>
                                        <th>课程名称</th>
                                        <th>授课老师</th>
                                        <th>星期</th>
                                        <th>上课时间</th>
                                        <th>下课时间</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <!-- Table Body -->
                                    <tbody>
                                    <!-- 全局函数 session 用于获取 Session 值 -->
                                    @foreach (session('courses') as $course)
                                        <tr>
                                            <td class="table-text">
                                                <div>{{ $course->courseid }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $course->name }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $course->teacher }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $course->week }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $course->start }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $course->end }}</div>
                                            </td>
                                            <td>
                                                <form action="{{ route('delete', ['stuid'=>session('stuid'), 'courseid'=>$course->courseid]) }}" method="POST">
                                                    {{ csrf_field() }}

                                                    <!-- 伪造DELETE请求 -->
                                                    {!! method_field('DELETE') !!}
                                                    <button>删除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    </li>

                    <li class="list-group-item">
                        <form class="form-inline" action="{{ route('queryCourseid') }}" method="POST">
                            {{ csrf_field() }}
                            <label for="courseid">课程编号</label>
                            <input type="text" class="form-control" id="courseid" name="courseid">
                            <button type="submit" class="btn btn-default">查询</button>
                        </form>
                    </li>
                    <li class="list-group-item">
                    @if (session('students'))
                        <div class="panel panel-default">
                            <div class="panel-heading">学生列表</div>
                            <div class="panel-body">
                                <table class="table table-striped task-table">
                                    <!-- Table Headings -->
                                    <thead>
                                        <th>学号</th>
                                        <th>学生姓名</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <!-- Table Body -->
                                    <tbody>
                                    @foreach (session('students') as $student)
                                        <tr>
                                            <td class="table-text">
                                                <div>{{ $student->stuid }}</div>
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $student->name }}</div>
                                            </td>
                                            <td>
                                                <form action="{{ route('delete', ['stuid'=>$student->stuid, 'courseid'=>session('courseid')]) }}" method="POST">
                                                    {{ csrf_field() }}

                                                    <!-- 伪造DELETE请求 -->
                                                    {!! method_field('DELETE') !!}
                                                    <button>删除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif    
                    </li>
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">课表的统计</div>
                <div class="panel-body">
                    <p>本模块实现了两种统计模式</p>
                    <p>一是通过输入学号查询一位学生的课程数量，</p>
                    <p>二是通过输入课程编号查询一门课程的学生数量。</p>
                </div>
                <!-- List group -->
                <ul class="list-group">

                    <li class="list-group-item">
                        <form class="form-inline" action="{{ route('queryStuidNumber') }}" method="POST">
                            {{ csrf_field() }}
                            <label for="stuid">学号</label>
                            <input type="text" class="form-control" id="stuid" name="stuid">
                            <button type="submit" class="btn btn-default">统计</button>
                        </form>
                    </li>
                    <li class="list-group-item">
                    @if (session('coursesNum'))
                        <div class="alert alert-success" role="alert">
                            <p>该学生共有 {{ session('coursesNum') }} 门课。</p>
                        </div>
                    @endif
                    </li>

                    <li class="list-group-item">
                        <form class="form-inline" action="{{ route('queryCourseidNumber') }}" method="POST">
                            {{ csrf_field() }}
                            <label for="courseid">课程编号</label>
                            <input type="text" class="form-control" id="courseid" name="courseid">
                            <button type="submit" class="btn btn-default">查询</button>
                        </form>
                    </li>
                    <li class="list-group-item">
                    @if (session('studentsNum'))
                        <div class="alert alert-success" role="alert">
                            <p>该门课共有 {{ session('tudentsNum') }} 个学生。</p>
                        </div>
                    @endif    
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection