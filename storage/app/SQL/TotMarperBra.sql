select branch.name as branch,(sum(unit_price) - sum(unit_cost))/sum(unit_cost) as margin from 
sales_invoice_detail as sales_detail
inner join sales_invoice as sales
on sales.id_sales_invoice = sales_detail.id_sales_invoice
left join app_branch as branch
on branch.id_branch = sales.id_branch
where sales.trans_date between @StartDate and @EndDate
group by sales.id_branch