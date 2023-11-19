<%@page import="java.util.GregorianCalendar, java.util.Calendar" %>

<%
    GregorianCalendar currentDate = new GregorianCalendar();
    int currentYear = currentDate.get(Calendar.YEAR);
%>
<footer>
    <p>
        &copy; <%= currentYear%> Bertucci BitBuzz
    </p>
</footer>
</body>
</html>
