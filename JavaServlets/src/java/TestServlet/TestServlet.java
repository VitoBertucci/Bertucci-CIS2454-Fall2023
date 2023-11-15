
package TestServlet;

import java.util.Enumeration;
import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class TestServlet extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try ( PrintWriter out = response.getWriter()) {
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet TestServlet</title>");            
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet TestServlet at " + request.getContextPath() + "</h1>");
            out.println("<div><a href=\"HelloServlet\">Hello Servlet</a></div>");
            out.println("<div>string: " + request.getQueryString() + "</div>");
            
            
            String parameterName = "";
            Enumeration e = request.getParameterNames();
            while (e.hasMoreElements() ) {
                parameterName = (String) e.nextElement();
                out.println(parameterName + ": " + 
                        request.getParameter(parameterName) + "<br/>");
            }
            
            String[] toppings = request.getParameterValues("toppings");
            for (String topping : toppings) {
                out.println("Topping: " + topping + "<br/>");
            }
            
            request.setAttribute("testingAttribute", "attribute");
            
//            String url  = "/thing";
//            getServletContext().getRequestDispatcher(url)
//                    .forward(request, response);
//            System.out.println("test test test");
//            out.println("</body>");
//            out.println("</html>");
        }
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    public String getServletInfo() {
        return "Short description";
    }

}
