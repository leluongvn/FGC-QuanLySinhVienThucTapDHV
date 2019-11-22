// Home Page
import HomePage from "./layout/HomeDefault.vue";

// Teacher
import Teacher from "./pages/teacher/Home.vue";
import TeacherUser from "./pages/teacher/User.vue";
import ListStudent from "./pages/teacher/Student.vue";
import ListCompany from "./pages/teacher/Company.vue";
import ListTeacher from "./pages/teacher/Teacher.vue";
import ListTopic from "./pages/teacher/Topic.vue";
import Create from "./pages/teacher/CreateInternship.vue"
import Internship from "./components/pages/internship/InternshipTime.vue"
import StudentReg from "./components/pages/internship/StudentReg.vue"

// Company
import Company from "./pages/company/Home.vue";

// Student
import Student from "./pages/student/Home.vue";
import CompaReg from "./pages/student/CompanyReg.vue";
import TopicReg from "./pages/student/TopicReg.vue";
import StudentPoint from "./pages/student/InternshipPoint.vue";
import StudentUser from "./pages/student/User.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomePage,
    children: [
      {
        path: "teacher",
        name: "teacher",
        component: Teacher,
        children:[
          {
            path: "create",
            name: "create",
            component: Create,
            redirect:"create/1",
            children:[
              {
                path: ":id",
                name: "internship",
                component: Internship
              },
              {
                path:'student/:id',
                name:'index',
                component: StudentReg
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
        children: [
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
          },
        ]
      }
    ]
  }
];
export default routes;
