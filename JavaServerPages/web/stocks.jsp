<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="stocks.Stock" %>
<c:import url="/views/header.jsp" />

<% 
    Stock stock = (Stock)request.getAttribute("stock");
%>

<h1>Stocks</h1>

<table>
    <tr>
        <th>Symbol</th>
        <th>Name</th>
        <th>Price</th>
    </tr>
    <c:forEach items="${stocks}" var="stock">
    <tr>        
        <td>${stock.symbol}</td>
        <td>${stock.name}</td>
        <td>${stock.currentPrice}</td>
    </tr>
    </c:forEach>
</table>

<c:import url="/views/footer.jsp" />