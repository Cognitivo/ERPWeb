select tag.name as category,(sum(sales_detail.unit_price) - sum(sales_detail.unit_cost))/sum(sales_detail.unit_cost) as margin
from sales_invoice_detail as sales_detail
inner join sales_invoice as sales
on sales.id_sales_invoice = sales_detail.id_sales_invoice
left join items
on items.id_item = sales_detail.id_item
left join item_tag_detail as tag_detail
on tag_detail.id_item = items.id_item
left join item_tag as tag
on tag.id_tag = tag_detail.id_tag
where sales.trans_date between @StartDate and @EndDate
group by tag.id_tag
