package classes;

public class ClassBody implements ASTNode{

        private ClassMember[] classMembers;

        public ClassMember[] getClassMembers() {
            return classMembers;
        }

        public void setClassMembers(ClassMember[] classMembers) {
            this.classMembers = classMembers;
        }

        @Override
        public String toString() {
            StringBuilder sb = new StringBuilder("\nClassBody{");
            if (classMembers != null) {
                for (ClassMember member : classMembers) {
                    sb.append("\n").append(member);
                }
            }
            sb.append("\n}");
            return sb.toString();
        }

}
