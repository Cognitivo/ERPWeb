select (sum(unit_price) - sum(unit_cost))/sum(unit_cost) as TotalMargin from 
sales_invoice_detail as sales_detail
inner join sales_invoice as sales
on sales.id_sales_invoice = sales_detail.id_sales_invoice
where sales.trans_date between @StartDate and @EndDate