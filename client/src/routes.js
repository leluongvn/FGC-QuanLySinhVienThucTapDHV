// Home Page
import HomePage from "./layout/HomeDefault.vue";
import Login from "./pages/Login.vue";
import Home from "./components/pages/Home.vue"
// Teacher
import Teacher from "./pages/teacher/Home.vue";
//Tra cứu TT
import TeacherUser from "./pages/teacher/User.vue";
import ListStudent from "./pages/teacher/Student.vue";
import ListCompany from "./pages/teacher/Company.vue";
import ListTeacher from "./pages/teacher/Teacher.vue";
import ListTopic from "./pages/teacher/Topic.vue";
import Create from "./pages/teacher/CreateInternship.vue";
// Hồ sơ thực tập
import Internship from "./components/pages/internship/InternshipTime.vue";
import Tabs from "./components/pages/internship/Tabs.vue";
import StudentReg from "./components/pages/internship/StudentReg.vue";
import InternshipCompany from "./components/pages/internship/InternshipCompany.vue";
import Point from "./components/pages/internship/InternshipPoint.vue";
import Instructor from "./components/pages/internship/Instructor.vue";
import InternshipTopic from "./components/pages/internship/InternshipTopic.vue";
import GuideStudent from "./components/pages/internship/StudentInstructor.vue";

// Company
import Company from "./pages/company/Home.vue";

// Student
import Student from "./pages/student/Home.vue";
import CompaReg from "./pages/student/CompanyReg.vue";
import TopicReg from "./pages/student/TopicReg.vue";
import StudentPoint from "./pages/student/InternshipPoint.vue";
import StudentUser from "./pages/student/User.vue";

//test
import test from "./Test.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomePage,
    redirect: "/home",
    children: [
      {
        path: "home",
        name: "home",
        component: Home
      },
      {
        path: "teacher",
        name: "teacher",
        component: Teacher,
        redirect: "teacher/home",
        children: [
          {
            path: "home",
            name: "home",
            component: Home
          },
          {
            path: "create",
            name: "create",
            component: Create,
            redirect: "create/1",
            children: [
              {
                path: ":id",
                name: "internship",
                component: Internship
              },
              {
                path: "internship",
                name: "internship",
                component: Tabs,
                // redirect:"internship/student-reg/1",
                children: [
                  {
                    path: "student-reg/:id",
                    name: "student-reg",
                    component: StudentReg
                  },
                  {
                    path: "company-reg/:id",
                    name: "company-reg",
                    component: InternshipCompany
                  },
                  {
                    path: "point/:id",
                    name: "point",
                    component: Point
                  },
                  {
                    path: "instructor/:id",
                    name: "instructor",
                    component: Instructor
                  },
                  {
                    path: "topic-reg/:id",
                    name: "topic-reg",
                    component: InternshipTopic
                  },
                  {
                    path: "guide-student/:id",
                    name: "guide-student",
                    component: GuideStudent
                  }
                ]
              }
            ]
          },
          {
            path: "user",
            name: "user",
            component: TeacherUser
          },
          {
            path: "list-teacher",
            name: "teacher",
            component: ListTeacher
          },
          {
            path: "list-student",
            name: "student",
            component: ListStudent
          },
          {
            path: "list-company",
            name: "company",
            component: ListCompany
          },
          {
            path: "list-topic",
            name: "topic",
            component: ListTopic
          }
        ]
      },
      {
        path: "company",
        name: "company",
        component: Company
      },
      {
        path: "student",
        name: "student",
        component: Student,
        redirect: "student/home",
        children: [
          {
            path: "home",
            name: "home",
            component: Home
          },
          {
            path: "company",
            name: "company",
            component: CompaReg
          },
          {
            path: "topic",
            name: "topic",
            component: TopicReg
          },
          {
            path: "point",
            name: "point",
            component: StudentPoint
          },
          {
            path: "user",
            name: "user",
            component: StudentUser
          }
        ]
      }
    ]
  },
  {
    path: "/login",
    name: "login",
    component: Login
  },
  {
    path: "/test",
    name: "test",
    component: test
  }
];
export default routes;
