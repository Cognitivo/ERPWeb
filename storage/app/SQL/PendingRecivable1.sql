  select
          contact.name as Contact,
          DATE_FORMAT(schedual.expire_date, "%M") as month,
          app_branch.name as Branch,
          round((schedual.debit - schedual.CreditChild),2) as Balance,
          DATE_FORMAT(schedual.expire_date, "%d/%m/%Y") as ExpireDate,
          ABS(DATEDIFF(schedual.expire_date,CURDATE())) as DelayDay,
          schedual.company as Company
          from (
              select
              parent.*,company.name as company,
              ( select if(sum(credit) is null, 0, sum(credit))
              from payment_schedual as child where child.parent_id_payment_schedual = parent.id_payment_schedual
              ) as CreditChild
              from payment_schedual as parent
              left join app_company as company
              on company.id_company = parent.id_company
              group by parent.id_payment_schedual
              ) as schedual
  
              inner join contacts as contact on schedual.id_contact = contact.id_contact
              inner join app_currencyfx as fx on schedual.id_currencyfx = fx.id_currencyfx
              inner join app_currency as curr on fx.id_currency = curr.id_currency
              inner join sales_invoice as si on schedual.id_sales_invoice = si.id_sales_invoice
              inner join app_branch on app_branch.id_branch = si.id_branch
              left join app_contract as contract on si.id_contract = contract.id_contract
              left join app_condition as cond on contract.id_condition = cond.id_condition
              where (schedual.debit - schedual.CreditChild) > 0
              and ABS(DATEDIFF(schedual.expire_date, CURDATE())) >0
              group by contact.id_contact
              order by schedual.expire_date